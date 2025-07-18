<?php

namespace App\Filament\Technician\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Technician Dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Technician\Widgets\TechnicianStatsOverview::class,
            \App\Filament\Technician\Widgets\MyRequestsChart::class,
            \App\Filament\Technician\Widgets\RecentRequestsTable::class,
            \App\Filament\Technician\Widgets\TodayRequestsStats::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }
}
