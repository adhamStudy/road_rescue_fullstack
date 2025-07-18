<?php

namespace App\Filament\Technician\Widgets;

use App\Models\ServiceRequest;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MyRequestsChart extends ChartWidget
{
    protected static ?string $heading = 'My Requests (Last 7 Days)';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $technician = auth('technician')->user();

        // Get data for last 7 days
        $dates = collect();
        $myRequestsData = collect();
        $allRequestsData = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dateLabel = now()->subDays($i)->format('M j');

            $dates->push($dateLabel);

            // My requests for this date
            $myCount = ServiceRequest::where('technician_id', $technician->id)
                ->whereDate('created_at', $date)
                ->count();
            $myRequestsData->push($myCount);

            // All requests for this date
            $allCount = ServiceRequest::whereDate('created_at', $date)->count();
            $allRequestsData->push($allCount);
        }

        return [
            'datasets' => [
                [
                    'label' => 'My Requests',
                    'data' => $myRequestsData->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
                [
                    'label' => 'All System Requests',
                    'data' => $allRequestsData->toArray(),
                    'backgroundColor' => 'rgba(156, 163, 175, 0.1)',
                    'borderColor' => 'rgb(156, 163, 175)',
                    'borderWidth' => 2,
                    'fill' => true,
                ],
            ],
            'labels' => $dates->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
