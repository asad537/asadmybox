<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CrmUser;
use App\CrmStatusLog;
use Carbon\Carbon;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->get('range', 'today'); // Default Today
        $search = $request->get('search');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        // Fetch CrmUsers
        $query = CrmUser::query();
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        $query->where('role', '!=', 'admin'); // Exclude Admins
        $users = $query->get();

        $performanceData = [];

        foreach ($users as $user) {
            // Define Date Range
            if ($start_date && $end_date) {
                // Custom Date Range
                $startDate = Carbon::parse($start_date)->startOfDay();
                $endDate = Carbon::parse($end_date)->endOfDay();
                $range = 'custom'; // Mark as custom for view logic if needed
            } else {
                // Predefined Ranges
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay(); // Default Today

                if ($range === 'this_week') {
                    $startDate = Carbon::now()->startOfWeek();
                    $endDate = Carbon::now()->endOfWeek();
                } elseif ($range === 'this_month') {
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                } elseif ($range === 'this_year') {
                    $startDate = Carbon::now()->startOfYear();
                    $endDate = Carbon::now()->endOfYear();
                }
            }
            
            // Query Logs based on user_name match
            $viewed = CrmStatusLog::where('user_name', $user->name)
                ->where('new_status', 'Viewed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $responded = CrmStatusLog::where('user_name', $user->name)
                ->where('new_status', 'Responded')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
                
            $orders = CrmStatusLog::where('user_name', $user->name)
                ->where('new_status', 'Order Done')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            $performanceData[] = [
                'name' => $user->name,
                'viewed' => $viewed,
                'responded' => $responded,
                'orders' => $orders
            ];
        }

        return view('crm.team.index', compact('performanceData', 'range', 'search', 'start_date', 'end_date'));
    }
}
