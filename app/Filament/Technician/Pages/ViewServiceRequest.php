<?php

namespace App\Filament\Technician\Resources\ServiceRequestResource\Pages;

use App\Filament\Technician\Resources\ServiceRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewServiceRequest extends ViewRecord
{
    protected static string $resource = ServiceRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn($record) => $record->status !== 'completed'),

            Actions\Action::make('assign_to_me')
                ->label('Assign to Me')
                ->icon('heroicon-o-user-plus')
                ->color('success')
                ->visible(fn($record) => $record->status === 'pending')
                ->action(function ($record) {
                    $record->update([
                        'technician_id' => auth('technician')->id(),
                        'status' => 'assigned'
                    ]);
                })
                ->requiresConfirmation()
                ->modalHeading('Assign Request')
                ->modalDescription('Are you sure you want to assign this request to yourself?')
                ->modalSubmitActionLabel('Yes, Assign'),

            Actions\Action::make('mark_completed')
                ->label('Mark as Completed')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn($record) => $record->status === 'assigned' && $record->technician_id === auth('technician')->id())
                ->action(function ($record) {
                    $record->update(['status' => 'completed']);
                    return redirect()->to('/technician/bills/create?service_request_id=' . $record->id);
                })
                ->requiresConfirmation()
                ->modalHeading('Mark as Completed')
                ->modalDescription('This will mark the service as completed and take you to create the bill.')
                ->modalSubmitActionLabel('Complete & Create Bill'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Request Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('Request ID')
                            ->formatStateUsing(fn($state) => '#' . $state)
                            ->badge()
                            ->color('primary'),

                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'pending' => 'warning',
                                'assigned' => 'info',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                            }),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Requested At')
                            ->dateTime(),

                        Infolists\Components\TextEntry::make('service.name')
                            ->label('Service Type')
                            ->badge()
                            ->color('gray'),
                    ])->columns(2),

                Infolists\Components\Section::make('Customer Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('user.name')
                            ->label('Customer Name')
                            ->icon('heroicon-o-user'),

                        Infolists\Components\TextEntry::make('user.phone')
                            ->label('Phone Number')
                            ->icon('heroicon-o-phone')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('user.email')
                            ->label('Email')
                            ->icon('heroicon-o-envelope')
                            ->copyable(),
                    ])->columns(3),

                Infolists\Components\Section::make('Vehicle Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('vehicle_type')
                            ->label('Vehicle Type')
                            ->icon('heroicon-o-truck'),

                        Infolists\Components\TextEntry::make('vehicle_model')
                            ->label('Vehicle Model')
                            ->icon('heroicon-o-wrench-screwdriver'),
                    ])->columns(2),

                Infolists\Components\Section::make('Service Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('service.description')
                            ->label('Service Description'),

                        Infolists\Components\TextEntry::make('service.price')
                            ->label('Service Price')
                            ->formatStateUsing(fn($state) => 'SAR ' . number_format($state, 2))
                            ->badge()
                            ->color('success'),

                        Infolists\Components\TextEntry::make('issue_description')
                            ->label('Issue Description')
                            ->columnSpanFull(),
                    ])->columns(2),

                Infolists\Components\Section::make('Assignment Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('technician.name')
                            ->label('Assigned Technician')
                            ->placeholder('Not assigned yet')
                            ->icon('heroicon-o-user-circle'),

                        Infolists\Components\TextEntry::make('technician.phone')
                            ->label('Technician Phone')
                            ->placeholder('N/A')
                            ->copyable(),

                        Infolists\Components\TextEntry::make('technician.rating')
                            ->label('Technician Rating')
                            ->formatStateUsing(fn($state) => $state ? $state . '/5 ⭐' : 'No rating')
                            ->placeholder('No rating'),
                    ])->columns(3)
                    ->visible(fn($record) => $record->technician_id !== null),

                Infolists\Components\Section::make('Location')
                    ->schema([
                        Infolists\Components\TextEntry::make('coordinates')
                            ->label('GPS Coordinates')
                            ->formatStateUsing(fn($record) => $record->lat . ', ' . $record->lng)
                            ->copyable(),

                        Infolists\Components\ViewEntry::make('map')
                            ->label('Location Map')
                            ->view('filament.technician.infolists.location-map')
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Billing Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('bill.total_amount')
                            ->label('Total Bill Amount')
                            ->formatStateUsing(fn($state) => $state ? 'SAR ' . number_format($state, 2) : 'Not billed yet')
                            ->badge()
                            ->color(fn($state) => $state ? 'success' : 'warning'),

                        Infolists\Components\TextEntry::make('bill.status')
                            ->label('Payment Status')
                            ->badge()
                            ->color(fn(string $state = null): string => match ($state) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                default => 'gray',
                            })
                            ->placeholder('No bill created'),

                        Infolists\Components\TextEntry::make('bill.is_night_service')
                            ->label('Night Service')
                            ->formatStateUsing(fn($state) => $state ? 'Yes (50% surcharge applied)' : 'No')
                            ->badge()
                            ->color(fn($state) => $state ? 'warning' : 'success')
                            ->placeholder('N/A'),
                    ])->columns(3)
                    ->visible(fn($record) => $record->status === 'completed'),
            ]);
    }
}
