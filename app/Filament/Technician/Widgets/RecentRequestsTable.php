<?php

namespace App\Filament\Technician\Widgets;

use App\Models\ServiceRequest;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentRequestsTable extends BaseWidget
{
    protected static ?string $heading = 'My Recent Requests';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        $technician = auth('technician')->user();

        return ServiceRequest::query()
            ->where('technician_id', $technician->id)
            ->with(['user', 'service'])
            ->latest()
            ->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->formatStateUsing(fn($state) => '#' . $state)
                ->sortable(),

            Tables\Columns\TextColumn::make('user.name')
                ->label('Customer')
                ->searchable(),

            Tables\Columns\TextColumn::make('service.name')
                ->label('Service')
                ->badge(),

            Tables\Columns\TextColumn::make('vehicle_type')
                ->label('Vehicle')
                ->formatStateUsing(fn($record) => $record->vehicle_type . ' - ' . $record->vehicle_model),

            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'pending' => 'warning',
                    'assigned' => 'info',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                }),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Requested')
                ->since()
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('view')
                ->icon('heroicon-m-eye')
                ->url(fn(ServiceRequest $record): string => "/technician/service-requests/{$record->id}"),
        ];
    }
}
