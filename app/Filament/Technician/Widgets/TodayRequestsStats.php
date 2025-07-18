<?php

namespace App\Filament\Technician\Widgets;

use Filament\Widgets\ChartWidget;

class TodayRequestsStats extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
