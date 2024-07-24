<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TableAvailability;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class StatisticController extends Controller
{
    public function index(Request $request)
    {
        return view('chart');
    }
    public function subscription(Request $request)
    {
        $labels = [];
        $data = [];
        $allTime = [];

        $startDate = Carbon::now()->subDays(10)->startOfDay(); // 15 days ago
        $endDate = Carbon::now()->endOfDay();

        $usersCreated = User::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at')
            ->get(['id', 'name', 'created_at'])
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('F d');
            });
        // Log::info('Users created last 15 days:', $usersCreated->toArray());

        $currentDate = clone $startDate;
        $current = User::where('created_at', '<=', $startDate)->count();
        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('F d'); // "F d"->"Month Day" (eg "January 1")
            $labels[] = $formattedDate;

            $count = isset($usersCreated[$formattedDate]) ? count($usersCreated[$formattedDate]) : 0;
            $data[] .= $count;
            $current += $count;
            $allTime[] .= $current;

            $currentDate->addDay();
        }
        // Log::info('Array : ', $data);

        $chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => "Per-day Subscription",
                    'data' => $data,
                    'borderColor' => 'blue',
                    'fill' => false,
                ],
                [
                    'label' => "All-time Subscription",
                    'data' => $allTime,
                    'borderColor' => 'green',
                    'fill' => false,
                ],
            ]
        ];

        return response()->json($chartData);
    }

    public function tablePopularity(Request $request)
    {
        // Retrieve top 5 popular table_id
        $top5Popular = TableAvailability::select(
            'tables.name as table_name',
            TableAvailability::raw('COUNT(*) as amount')
        )
            ->join('tables', 'table_availabilities.table_id', '=', 'tables.id')
            ->groupBy('table_availabilities.table_id', 'tables.name')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->get();
        // Log::info($top5Popular);

        foreach ($top5Popular as $item) {
            $labels[] = $item['table_name'];
            $data[] = $item['amount'];
        }
        $top5Count = array_sum($data);
        $totalCount = TableAvailability::all()->count();
        $labels[] = 'Others';
        $data[] = $totalCount - $top5Count;

        $response = [
            'labels' => $labels,
            'data' => $data,
        ];
        return response()->json($response);
    }
}
