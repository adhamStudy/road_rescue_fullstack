<?php

namespace App\Filament\Technician\Resources;

use App\Filament\Technician\Resources\ServiceRequestResource\Pages;
use App\Models\ServiceRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;

class ServiceRequestResource extends Resource
{
    protected static ?string $model = ServiceRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Service Requests';

    protected static ?string $pluralModelLabel = 'Service Requests';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'assigned' => 'Assigned',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->disabled(fn($record) => $record?->status === 'completed'),

                Forms\Components\Textarea::make('issue_description')
                    ->label('Issue Description')
                    ->disabled()
                    ->rows(3),

                Forms\Components\TextInput::make('vehicle_type')
                    ->label('Vehicle Type')
                    ->disabled(),

                Forms\Components\TextInput::make('vehicle_model')
                    ->label('Vehicle Model')
                    ->disabled(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
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

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime(),
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
                    ])->columns(2),

                Infolists\Components\Section::make('Service Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('service.name')
                            ->label('Service Type')
                            ->icon('heroicon-o-wrench-screwdriver'),

                        Infolists\Components\TextEntry::make('service.description')
                            ->label('Service Description')
                            ->default('No description available'),

                        Infolists\Components\TextEntry::make('service.price')
                            ->label('Service Price')
                            ->formatStateUsing(fn($state) => 'SAR ' . number_format($state, 2))
                            ->icon('heroicon-o-currency-dollar'),

                        Infolists\Components\TextEntry::make('technician.name')
                            ->label('Assigned Technician')
                            ->default('Not assigned yet')
                            ->icon('heroicon-o-user-circle'),
                    ])->columns(2),

                Infolists\Components\Section::make('Vehicle Information')
                    ->schema([
                        Infolists\Components\TextEntry::make('vehicle_type')
                            ->label('Vehicle Type')
                            ->icon('heroicon-o-truck'),

                        Infolists\Components\TextEntry::make('vehicle_model')
                            ->label('Vehicle Model')
                            ->icon('heroicon-o-identification'),
                    ])->columns(2),

                Infolists\Components\Section::make('Issue Description')
                    ->schema([
                        Infolists\Components\TextEntry::make('issue_description')
                            ->label('Customer Description')
                            ->default('No description provided')
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Service Location')
                    ->schema([
                        Infolists\Components\TextEntry::make('location_coordinates')
                            ->label('Coordinates')
                            ->formatStateUsing(
                                fn($record) =>
                                $record->lat && $record->lng
                                    ? "Latitude: {$record->lat}, Longitude: {$record->lng}"
                                    : 'Location not available'
                            )
                            ->icon('heroicon-o-map-pin')
                            ->copyable(),

                        Infolists\Components\ViewEntry::make('location_map')
                            ->label('Service Location Map')
                            ->view('filament.technician.service-request-map')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Request #')
                    ->formatStateUsing(fn($state) => '#' . $state)
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.phone')
                    ->label('Phone')
                    ->searchable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Service Type')
                    ->sortable(),

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

                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Assigned To')
                    ->default('Unassigned'),

                Tables\Columns\TextColumn::make('location_info')
                    ->label('Location')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->lat && $record->lng
                            ? '📍 Available'
                            : '❌ No location'
                    )
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Requested At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'assigned' => 'Assigned',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Service Type')
                    ->relationship('service', 'name'),

                Tables\Filters\Filter::make('has_location')
                    ->label('Has Location')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('lat')->whereNotNull('lng'))
                    ->toggle(),

                Tables\Filters\Filter::make('my_assignments')
                    ->label('My Assignments')
                    ->query(fn(Builder $query): Builder => $query->where('technician_id', auth('technician')->id()))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View Details')
                    ->icon('heroicon-o-eye'),

                Tables\Actions\Action::make('assign_to_me')
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

                Tables\Actions\Action::make('mark_completed')
                    ->label('Mark as Completed')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'assigned' && $record->technician_id === auth('technician')->id())
                    ->action(function ($record) {
                        // Update status to completed
                        $record->update(['status' => 'completed']);

                        // Redirect to bill creation
                        return redirect()->to('/technician/bills/create?service_request_id=' . $record->id);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Mark as Completed')
                    ->modalDescription('This will mark the service as completed and take you to create the bill.')
                    ->modalSubmitActionLabel('Complete & Create Bill'),

                Tables\Actions\Action::make('view_location')
                    ->label('View Location')
                    ->icon('heroicon-o-map-pin')
                    ->color('info')
                    ->visible(fn($record) => $record->lat && $record->lng)
                    ->url(fn($record) => "https://www.google.com/maps?q={$record->lat},{$record->lng}")
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('assign_selected')
                        ->label('Assign Selected to Me')
                        ->icon('heroicon-o-user-plus')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'technician_id' => auth('technician')->id(),
                                        'status' => 'assigned'
                                    ]);
                                }
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Assign Multiple Requests')
                        ->modalDescription('Are you sure you want to assign all selected pending requests to yourself?'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                $technician = auth('technician')->user();
                // Show all pending requests + requests assigned to current technician
                return $query->where(function ($q) use ($technician) {
                    $q->where('status', 'pending')
                        ->orWhere('technician_id', $technician->id);
                });
            })
            ->recordUrl(fn($record) => static::getUrl('view', ['record' => $record])); // Enable row click to view
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceRequests::route('/'),
            'view' => Pages\ViewServiceRequest2::route('/{record}'),
            'edit' => Pages\EditServiceRequest::route('/{record}/edit'),
        ];
    }
}
