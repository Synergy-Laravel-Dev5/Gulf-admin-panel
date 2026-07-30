<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Models\VisaCountry;
use App\Models\VisaType;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalApplications      = VisaApplication::count();
        $pendingApplications    = VisaApplication::where('status', 'pending')->count();
        $inProgressApplications = VisaApplication::where('status', 'in_progress')->count();
        $approvedApplications   = VisaApplication::whereIn('status', ['approved', 'won'])->count();
        $rejectedApplications   = VisaApplication::whereIn('status', ['rejected', 'loss'])->count();

        $totalCountries = VisaCountry::count();
        $totalVisaTypes = VisaType::count();

        $approvalRate = $totalApplications > 0
            ? round(($approvedApplications / $totalApplications) * 100, 1)
            : 0;

        $thisWeek = VisaApplication::where('created_at', '>=', now()->subDays(7))->count();
        $lastWeek = VisaApplication::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count();
        $weeklyGrowth = $lastWeek > 0
            ? round((($thisWeek - $lastWeek) / $lastWeek) * 100, 1)
            : ($thisWeek > 0 ? 100 : 0);

        $monthlyRaw = VisaApplication::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as ym"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $chartLabels = collect(range(0, 11))
            ->map(fn ($i) => now()->subMonths(11 - $i)->format('M'));

        $chartData = collect(range(0, 11))
            ->map(fn ($i) => $monthlyRaw[now()->subMonths(11 - $i)->format('Y-m')] ?? 0);

        $statusBreakdown = VisaApplication::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusChartLabels = $statusBreakdown->keys()
            ->map(fn ($status) => ucfirst(str_replace('_', ' ', $status)))
            ->values()
            ->all();

        $statusChartSeries = $statusBreakdown->values()->all();

        $applicationsByCountry = VisaCountry::withCount('applications')
            ->orderByDesc('applications_count')
            ->take(5)
            ->get()
            ->map(function ($country) use ($totalApplications) {
                $country->percentage = $totalApplications > 0
                    ? round(($country->applications_count / $totalApplications) * 100)
                    : 0;
                return $country;
            });

        $thisYearCount = VisaApplication::whereYear('created_at', now()->year)->count();
        $lastYearCount = VisaApplication::whereYear('created_at', now()->subYear()->year)->count();

        $recentApplications = VisaApplication::with(['visaType.country'])
            ->latest()
            ->take(7)
            ->get();

        return view('dashboard', compact(
            'totalApplications',
            'pendingApplications',
            'inProgressApplications',
            'approvedApplications',
            'rejectedApplications',
            'totalCountries',
            'totalVisaTypes',
            'approvalRate',
            'weeklyGrowth',
            'chartLabels',
            'chartData',
            'statusBreakdown',
            'statusChartLabels',
            'statusChartSeries',
            'applicationsByCountry',
            'thisYearCount',
            'lastYearCount',
            'recentApplications'
        ));
    }
}