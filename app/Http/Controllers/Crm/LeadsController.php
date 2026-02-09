<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CrmEmail;

class LeadsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('export')) {
            return $this->exportLeads($request);
        }

        $query = CrmEmail::select('id', 'client_name', 'client_email', 'client_phone', 'created_at', 'status', 'product_name', 'quantity')
                        ->where('is_spam', false)
                        ->orderBy('created_at', 'desc');

        // Status Filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Date Range Filter
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->has('date_filter') && $request->date_filter != '') {
            if ($request->date_filter == 'today') {
                $query->whereDate('created_at', \Carbon\Carbon::today());
            } elseif ($request->date_filter == 'yesterday') {
                $query->whereDate('created_at', \Carbon\Carbon::yesterday());
            } elseif ($request->date_filter == 'this_week') {
                $query->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
            }
        }

        // Product Filter
        if ($request->has('product') && $request->product != '') {
            $query->where('product_name', $request->product);
        }

        // Global Search Filter (All Fields)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('client_email', 'like', "%{$search}%")
                  ->orWhere('client_phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // Fetch Unique Products for Dropdown
        // Fetch Unique Products for Dropdown (Exclude Spam)
        $products = CrmEmail::select('product_name')
                            ->where('is_spam', false)
                            ->distinct()
                            ->whereNotNull('product_name')
                            ->pluck('product_name');

        $leads = $query->paginate(9);

        return view('crm.leads.index', compact('leads', 'products'));
    }

    protected function exportLeads(Request $request)
    {
        $startDate = $request->start_date ? \Carbon\Carbon::parse($request->start_date) : \Carbon\Carbon::today();
        $endDate = $request->end_date ? \Carbon\Carbon::parse($request->end_date) : \Carbon\Carbon::today();
        $endDate->setTime(23, 59, 59);

        // Fetch all emails (including spam)
        $emails = CrmEmail::select('id', 'client_email', 'status', 'is_spam', 'created_at')
                          ->whereBetween('created_at', [$startDate, $endDate])
                          ->orderBy('created_at', 'asc')
                          ->get();

        $dailyData = [];
        $totals = [
            'Queries' => 0, 'New' => 0, 'Retrine' => 0, 'Spam' => 0,
            'Order Done' => 0, 'Replied' => 0, 'Read' => 0, 'Unread' => 0
        ];

        foreach ($emails as $email) {
            $date = $email->created_at->format('Y-m-d');
            if (!isset($dailyData[$date])) {
                $dailyData[$date] = [
                    'Queries' => 0, 'New' => 0, 'Retrine' => 0, 'Spam' => 0,
                    'Order Done' => 0, 'Replied' => 0, 'Read' => 0, 'Unread' => 0
                ];
            }

            if ($email->is_spam) {
                $dailyData[$date]['Spam']++;
                $totals['Spam']++;
                continue;
            }

            // Valid Queries (Non-Spam)
            $dailyData[$date]['Queries']++;
            $totals['Queries']++;

            // Status Counts
            if ($email->status == 'Order Done') { $dailyData[$date]['Order Done']++; $totals['Order Done']++; }
            elseif ($email->status == 'Responded') { $dailyData[$date]['Replied']++; $totals['Replied']++; }
            elseif ($email->status == 'Viewed') { $dailyData[$date]['Read']++; $totals['Read']++; }
            elseif ($email->status == 'New') { $dailyData[$date]['Unread']++; $totals['Unread']++; }

            // Customer Type (New vs Retrine)
            if ($email->customer_type == 'RC') {
                $dailyData[$date]['Retrine']++;
                $totals['Retrine']++;
            } else {
                $dailyData[$date]['New']++;
                $totals['New']++;
            }
        }

        $filename = "leads_export_" . now()->format('Ymd_His') . ".xls";
        
        $startDateStr = $startDate->format('Y-m-d');
        $endDateStr = $endDate->format('Y-m-d');

        return response(view('crm.leads.export', [
            'dailyData' => $dailyData, 
            'totals' => $totals, 
            'startDate' => $startDateStr, 
            'endDate' => $endDateStr
        ]))
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"")
            ->header('Pragma', 'no-cache')
            ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->header('Expires', '0');
    }
}
