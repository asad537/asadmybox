<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CrmEmail;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $query = CrmEmail::where('is_spam', false)->orderBy('created_at', 'desc');

        // Status Filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Product Filter
        if ($request->has('product') && $request->product != '') {
            $query->where('product_name', $request->product);
        }

        // Live Search (Keyword)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('client_email', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('date_filter') && $request->date_filter != '') {
            $this->applyDateFilter($query, $request->date_filter);
        }

        // Fetch Unique Products for Dropdown
        $products = CrmEmail::select('product_name')->distinct()->whereNotNull('product_name')->pluck('product_name');

        $emails = $query->paginate(8);
        return view('crm.emails.index', compact('emails', 'products'));
    }

    public function spam(Request $request)
    {
        $query = CrmEmail::where('is_spam', true)->orderBy('created_at', 'desc');

        if ($request->has('date_filter') && $request->date_filter != '') {
            $this->applyDateFilter($query, $request->date_filter);
        }

        $emails = $query->paginate(8);
        return view('crm.emails.spam', compact('emails'));
    }

    private function applyDateFilter($query, $filter)
    {
        if ($filter == 'today') {
            $query->whereDate('created_at', \Carbon\Carbon::today());
        } elseif ($filter == 'yesterday') {
            $query->whereDate('created_at', \Carbon\Carbon::yesterday());
        } elseif ($filter == 'this_week') {
            $query->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
        }
    }

    public function show($id)
    {
        $email = CrmEmail::findOrFail($id);

        // Only update status if the user is NOT an Admin
        if (!\Auth::guard('crm')->user()->isAdmin() && $email->status == 'New') {
            $oldStatus = 'New';
            $newStatus = 'Viewed';
            
            $email->update(['status' => $newStatus]);
            
            // Log the status change
            $existingLog = \App\CrmStatusLog::where('crm_email_id', $email->id)->first();

            if ($existingLog) {
                $existingLog->update([
                    'user_name' => \Auth::guard('crm')->user()->name,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'created_at' => now(),
                ]);
            } else {
                \App\CrmStatusLog::create([
                    'crm_email_id' => $email->id,
                    'user_name' => \Auth::guard('crm')->user()->name,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ]);
            }
        }

        // Fetch Product Image & URL
        $productDetails = null;
        if ($email->product_name) {
            $productDetails = \Illuminate\Support\Facades\DB::table('products')
                ->where('prod_name', $email->product_name)
                ->select('prod_image', 'prod_url')
                ->first();
        }

        return view('crm.emails.show', compact('email', 'productDetails'));
    }

    public function markAsSpam($id)
    {
        $email = CrmEmail::findOrFail($id);
        $email->update(['is_spam' => true]);
        return redirect()->back()->with('success', 'Email marked as spam.');
    }

    public function markAsValid($id)
    {
        $email = CrmEmail::findOrFail($id);
        $email->update(['is_spam' => false]);
        return redirect()->back()->with('success', 'Email marked as valid.');
    }

    public function updateStatus(Request $request, $id)
    {
        $email = CrmEmail::findOrFail($id);
        $oldStatus = $email->status;
        $newStatus = $request->input('status');

        if ($oldStatus !== $newStatus) {
            $email->update(['status' => $newStatus]);
            
            // Check if a log already exists for this email today to update it instead of creating a new one
            // However, typically logs are historical.
            // If the user wants "one log per email" (meaning only show the LATEST status change),
            // then we should update the existing log row if it exists?
            // "ik emails ka multiple logs na bna supose il eamils ka hi og rha" -> "Don't make multiple logs for one email, suppose [it's just] one email's log staying". 
            // This implies he wants ONLY THE LATEST log entry for that email, or maybe overwrite the last one?
            // Interpreting as: Update the LATEST log entry if it exists, OR delete old logs for this email and keep only the new one?
            // Usually "Logs" implies history. If he wants to avoid clutter, maybe he means "Update the existing log entry for this email if it exists, otherwise create it".
            // Let's assume he wants to maintain a SINGLE status log entry per email (the most recent one).
            
            // Checking if a log entry exists for this email
            $existingLog = \App\CrmStatusLog::where('crm_email_id', $email->id)->first();

            if ($existingLog) {
                // Update existing log
                $existingLog->update([
                    'user_name' => \Auth::guard('crm')->user()->name,
                    'old_status' => $oldStatus, // Optionally keep the original old status or update to current old status? 
                    // Usually if we are just tracking "Current Status Info", we update everything.
                    // If we overwrite, we lose the 'history' of 'New -> Viewed'. If we go 'Viewed -> Responded', do we want to see 'New -> Responded' or just 'Viewed -> Responded'?
                    // Let's update it to reflect the specific change event, but overwrite the record.
                    'new_status' => $newStatus,
                    'created_at' => now(), // Update timestamp to show when it happened
                ]);
            } else {
                // Create new log
                \App\CrmStatusLog::create([
                    'crm_email_id' => $email->id,
                    'user_name' => \Auth::guard('crm')->user()->name,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function destroy($id)
    {
        if (!\Auth::guard('crm')->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Only Admins can delete emails.');
        }

        $email = CrmEmail::findOrFail($id);
        $email->delete(); // Soft delete

        return redirect()->route('crm.emails.index')->with('success', 'Email deleted successfully.');
    }

    public function forward(Request $request, $id)
    {
        $request->validate(['forward_email' => 'required|email']);
        $email = CrmEmail::findOrFail($id);
        
        try {
            \Illuminate\Support\Facades\Mail::to($request->forward_email)->send(new \App\Mail\ForwardedInquiry($email));
            return redirect()->back()->with('success', 'Inquiry forwarded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }
}
