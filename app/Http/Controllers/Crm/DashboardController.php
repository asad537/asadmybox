<?php

namespace App\Http\Controllers\Crm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CrmEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->get('range', 'today');
        $now = Carbon::now();

        // Initialize defaults
        $statsStartDate = $now->copy()->startOfDay();
        $chartStartDate = $now->copy()->subDays(6)->startOfDay();
        $labels = [];

        // 1. Determine Date Range & Labels
        if ($range === 'weekly') {
            // Stats: This Week
            $statsStartDate = $now->copy()->startOfWeek();
            // Chart: Last 4 Weeks
            $chartStartDate = $now->copy()->subWeeks(3)->startOfWeek(); 
            for ($i = 0; $i < 4; $i++) {
                $labels[] = 'Week ' . ($i + 1);
            }
        } elseif ($range === 'monthly') {
            // Stats: This Month
            $statsStartDate = $now->copy()->startOfMonth();
            // Chart: This Year (Jan-Dec)
            $chartStartDate = $now->copy()->startOfYear();
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        } elseif ($range === 'yearly') {
            // Stats: This Year
            $statsStartDate = $now->copy()->startOfYear();
            // Chart: Last 5 Years
            $chartStartDate = $now->copy()->subYears(4)->startOfYear();
            for ($i = 0; $i < 5; $i++) {
                $labels[] = $chartStartDate->copy()->addYears($i)->format('Y');
            }
        } else { // Today (Default)
            // Stats: Today Only
            $statsStartDate = $now->copy()->startOfDay();
            // Chart: Last 10 Days Trend
            $chartStartDate = $now->copy()->subDays(9)->startOfDay();
            for ($i = 0; $i < 10; $i++) {
                $labels[] = $chartStartDate->copy()->addDays($i)->format('d M');
            }
        }

        // 2. Fetch Stats & Calculate Trends
        // Define Current vs Previous Ranges
        $prevStartDate = null;
        $prevEndDate = null;
        $currentEndDate = $now->copy();

        if ($range === 'today') {
            $prevStartDate = $now->copy()->subDay()->startOfDay();
            $prevEndDate = $now->copy()->subDay()->endOfDay();
        } elseif ($range === 'weekly') {
            $prevStartDate = $now->copy()->subWeek()->startOfWeek();
            $prevEndDate = $now->copy()->subWeek()->endOfWeek();
        } elseif ($range === 'monthly') {
            $prevStartDate = $now->copy()->subMonth()->startOfMonth();
            $prevEndDate = $now->copy()->subMonth()->endOfMonth();
        } elseif ($range === 'yearly') {
            $prevStartDate = $now->copy()->subYear()->startOfYear();
            $prevEndDate = $now->copy()->subYear()->endOfYear();
        }

        // Helper to get count
        $getCount = function($isSpam, $status = null) use ($statsStartDate, $currentEndDate) {
            $q = CrmEmail::where('is_spam', $isSpam)->whereBetween('created_at', [$statsStartDate, $currentEndDate]);
            if ($status) $q->where('status', $status);
            return $q->count();
        };
        
        $getPrevCount = function($isSpam, $status = null) use ($prevStartDate, $prevEndDate) {
            $q = CrmEmail::where('is_spam', $isSpam)->whereBetween('created_at', [$prevStartDate, $prevEndDate]);
            if ($status) $q->where('status', $status);
            return $q->count();
        };

        // Current Counts
        $totalEmails = $getCount(false);
        $spamEmails = CrmEmail::where('is_spam', true)->whereBetween('created_at', [$statsStartDate, $currentEndDate])->count();
        $repliedEmails = $getCount(false, 'Responded');
        $ordersDone = $getCount(false, 'Order Done');

        // Previous Counts
        $prevTotal = $getPrevCount(false);
        $prevSpam = CrmEmail::where('is_spam', true)->whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();
        $prevReplied = $getPrevCount(false, 'Responded');
        $prevOrders = $getPrevCount(false, 'Order Done');

        // Calculate Percentage Change
        $calcTrend = function($current, $prev) {
            if ($prev == 0) return $current > 0 ? 100 : 0;
            return round((($current - $prev) / $prev) * 100, 1);
        };

        $trends = [
            'total' => $calcTrend($totalEmails, $prevTotal),
            'spam' => $calcTrend($spamEmails, $prevSpam),
            'replied' => $calcTrend($repliedEmails, $prevReplied),
            'orders' => $calcTrend($ordersDone, $prevOrders)
        ];

        // 3. Compute Chart Trends (using Chart Range)
        $rawChartData = CrmEmail::where('created_at', '>=', $chartStartDate)
            ->get(['created_at', 'status', 'is_spam']);
        
        $chartReplied = array_fill(0, count($labels), 0);
        $chartPending = array_fill(0, count($labels), 0);
        $chartTotal = array_fill(0, count($labels), 0);
        $chartSpam = array_fill(0, count($labels), 0);
        $chartOrders = array_fill(0, count($labels), 0);
        
        foreach ($rawChartData as $email) {
            $idx = -1;
            $ts = Carbon::parse($email->created_at);

            if ($range === 'today' || $range === 'daily') {
                // Index = Diff in days from start
                $idx = $ts->diffInDays($chartStartDate->copy()->startOfDay()); 
            } elseif ($range === 'weekly') {
                // Index = Diff in weeks
                $idx = floor($ts->diffInDays($chartStartDate) / 7);
            } elseif ($range === 'monthly') {
                $idx = $ts->month - 1;
            } elseif ($range === 'yearly') {
                $idx = $ts->year - $chartStartDate->year;
            }

            // Safety check for index
            if ($idx < 0) $idx = 0; 
            if ($idx >= count($labels)) $idx = count($labels) - 1;

            if ($idx >= 0 && $idx < count($labels)) {
                 if ($email->is_spam) {
                     $chartSpam[$idx]++;
                 } else {
                     $chartTotal[$idx]++; // Increment Total Non-Spam
                     
                     if (in_array($email->status, ['Responded', 'Order Done', 'Closed'])) {
                         $chartReplied[$idx]++;
                     } else { // Pending
                         $chartPending[$idx]++;
                     }

                     if ($email->status === 'Order Done') {
                         $chartOrders[$idx]++;
                     }
                 }
            }
        }
        
        $chartTrends = [
            'labels' => $labels,
            'total' => $chartTotal, 
            'replied' => $chartReplied,
            'pending' => $chartPending,
            'orders' => $chartOrders,
            'spam' => $chartSpam
        ];

        // 4. AJAX Response
        if ($request->ajax()) {
            return response()->json([
                'stats' => [
                    'total' => number_format($totalEmails),
                    'spam' => number_format($spamEmails),
                    'replied' => number_format($repliedEmails),
                    'orders' => number_format($ordersDone),
                ],
                'trends' => $trends, // Pass Trends
                'chart' => $chartTrends
            ]);
        }

        // 5. Initial Page Load (Full Data)
        // We need existing variables: sources, followups, recent, location
        // We'll fetch these as "Recent/All Time" to keep the dashboard populated
        
        $recentEmails = CrmEmail::where('is_spam', false)->orderBy('created_at', 'desc')->take(8)->get();
        
        $followUps = CrmEmail::where('is_spam', false)
            ->where('status', 'Viewed')
            ->where('created_at', '<', Carbon::now()->subHours(24))
            ->orderBy('created_at', 'asc')->take(5)->get();

        // Source Chart (All Time for better distribution data)
        $sourcesRaw = CrmEmail::where('is_spam', false)->take(100)->get(); // Limit for perf
        $sourceCounts = ['Contact Us'=>0,'Product Page'=>0,'Quote Request'=>0,'Other'=>0];
        foreach ($sourcesRaw as $email) {
             $src = $email->product_name ?? $email->subject;
             if (stripos($src, 'Quote')!==false) $sourceCounts['Quote Request']++;
             elseif (stripos($src, 'Contact')!==false) $sourceCounts['Contact Us']++;
             else $sourceCounts['Other']++;
        }
        $sourceChartData = ['labels'=>array_keys($sourceCounts), 'data'=>array_values($sourceCounts)];
        
        // Location Data (Simplified for brevity, keeps existing logic mostly)
        $emailsForLoc = CrmEmail::where('is_spam', false)->get();
        $locationCounts = [];
        foreach ($emailsForLoc as $r) {
             $c = $r->country ?: 'USA'; 
             if (!isset($locationCounts[$c])) $locationCounts[$c]=0; 
             $locationCounts[$c]++; 
        }
        arsort($locationCounts);
        $locationData = [];
        $totalLoc = $emailsForLoc->count();
        foreach(array_slice($locationCounts,0,3) as $k=>$v) {
            $locationData[] = ['name'=>$k, 'percent'=> $totalLoc?round($v/$totalLoc*100):0];
        }

        // Dummy Variables for View to prevent errors (Month comparison)
        $totalMonth = 0; $newMonth = 0; $pendingMonth = 0; $ordersMonth = 0;
        $spamMonth = 0; $repliedMonth = 0;
        $statusChartData = ['labels'=>[], 'data'=>[]]; // Not used if we update chartTrends

        return view('crm.dashboard', compact(
            'totalEmails', 'spamEmails', 'repliedEmails', 'ordersDone', 'trends',
            'chartTrends', 'recentEmails', 'followUps', 
            'sourceChartData', 'locationData',
            'totalMonth', 'newMonth', 'pendingMonth', 'ordersMonth', 'spamMonth', 'repliedMonth', 'statusChartData'
        ));
    }
}
