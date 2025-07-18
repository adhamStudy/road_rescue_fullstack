<?php

namespace App\Filament\Technician\Widgets;

use App\Models\ServiceRequest;
use App\Models\Technician;
use App\Models\Bill;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TechnicianStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $technician = auth('technician')->user();
        $today = now()->format('Y-m-d');

        // My statistics
        $myTotalRequests = ServiceRequest::where('technician_id', $technician->id)->count();
        $myCompletedToday = ServiceRequest::where('technician_id', $technician->id)
            ->where('status', 'completed')
            ->whereDate('updated_at', $today)
            ->count();
        $myPendingRequests = ServiceRequest::where('technician_id', $technician->id)
            ->where('status', 'assigned')
            ->count();

        // System-wide statistics
        $availableTechnicians = Technician::where('status', 'active')
            ->where('is_available', true)
            ->count();
        $totalRequestsToday = ServiceRequest::whereDate('created_at', $today)->count();
        $completedRequestsToday = ServiceRequest::where('status', 'completed')
            ->whereDate('updated_at', $today)
            ->count();

        // My earnings today
        $myEarningsToday = Bill::where('technician_id', $technician->id)
            ->whereDate('created_at', $today)
            ->where('status', 'paid')
            ->sum('total_amount');

        return [
            Stat::make('My Total Requests', $myTotalRequests)
                ->description('All time completed')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('My Pending Requests', $myPendingRequests)
                ->description('Currently assigned to me')
                ->descriptionIcon('heroicon-m-clock')
                ->color($myPendingRequests > 0 ? 'warning' : 'success'),

            Stat::make('Available Technicians', $availableTechnicians)
                ->description('Currently online')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Requests Today', $totalRequestsToday)
                ->description('System-wide today')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('primary'),

            Stat::make('Completed Today', $completedRequestsToday)
                ->description('System-wide completed')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('My Earnings Today', 'SAR ' . number_format($myEarningsToday, 2))
                ->description('From completed services')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
