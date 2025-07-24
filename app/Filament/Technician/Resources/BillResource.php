<?php

namespace App\Filament\Technician\Resources;

use App\Filament\Technician\Resources\BillResource\Pages;
use App\Models\Bill;
use App\Models\ServiceRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Bills';

    protected static ?string $pluralModelLabel = 'Bills';

    /**
     * Calculate totals based on current form state
     */
    private static function calculateTotals(callable $get, callable $set): void
    {
        $basePrice = floatval($get('base_price') ?? 0);
        $isNightService = $get('is_night_service') ?? false;

        // Calculate night tax (50% surcharge for night services)
        $nightTax = $isNightService ? ($basePrice * 0.5) : 0;
        $totalAmount = $basePrice + $nightTax;

        $set('night_tax', round($nightTax, 2));
        $set('total_amount', round($totalAmount, 2));
    }

    /**
     * Determine if current time is night service hours (10 PM - 6 AM)
     */
    private static function isNightServiceTime(): bool
    {
        $currentHour = now()->hour;
        return $currentHour >= 22 || $currentHour < 6;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Service Information')
                    ->description(fn($record) => $record !== null ? 'Service details cannot be modified after bill creation.' : null)
                    ->schema([
                        Forms\Components\Select::make('service_request_id')
                            ->label('Service Request')
                            ->options(function ($record) {
                                $query = ServiceRequest::where('technician_id', auth('technician')->id())
                                    ->where('status', 'completed')
                                    ->with(['user', 'service']);

                                // If editing, include the current bill's service request
                                if ($record) {
                                    $query->where(function ($q) use ($record) {
                                        $q->whereDoesntHave('bill')
                                            ->orWhere('id', $record->service_request_id);
                                    });
                                } else {
                                    // If creating, only show requests without bills
                                    $query->whereDoesntHave('bill');
                                }

                                return $query->get()
                                    ->mapWithKeys(function ($request) {
                                        return [$request->id => "#{$request->id} - {$request->user->name} - {$request->service->name}"];
                                    });
                            })
                            ->required()
                            ->disabled(fn($record) => $record !== null) // Disable during edit
                            ->live() // Use live() instead of reactive() for better performance
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $serviceRequest = ServiceRequest::with(['user', 'service', 'technician'])->find($state);
                                    if ($serviceRequest && $serviceRequest->service) {
                                        // Set basic fields
                                        $set('user_id', $serviceRequest->user_id);
                                        $set('technician_id', $serviceRequest->technician_id);
                                        $set('service_id', $serviceRequest->service_id);
                                        $set('base_price', $serviceRequest->service->price);

                                        // Auto-detect night service based on current time
                                        $isNightService = self::isNightServiceTime();
                                        $set('is_night_service', $isNightService);

                                        // Calculate totals
                                        self::calculateTotals($get, $set);
                                    }
                                } else {
                                    // Clear fields when no service request selected
                                    $set('user_id', null);
                                    $set('technician_id', null);
                                    $set('service_id', null);
                                    $set('base_price', 0);
                                    $set('is_night_service', false);
                                    $set('night_tax', 0);
                                    $set('total_amount', 0);
                                }
                            }),

                        Forms\Components\Hidden::make('user_id'),
                        Forms\Components\Hidden::make('technician_id'),
                        Forms\Components\Hidden::make('service_id'),
                    ]),

                Forms\Components\Section::make('Pricing Details')
                    ->description(fn($record) => $record !== null ? 'Pricing cannot be modified after bill creation.' : null)
                    ->schema([
                        Forms\Components\TextInput::make('base_price')
                            ->label('Base Service Price (SAR)')
                            ->numeric()
                            ->required()
                            ->disabled(fn($record) => $record !== null) // Disable during edit
                            ->live() // Use live() for real-time updates
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                // Recalculate totals when base price changes
                                self::calculateTotals($get, $set);
                            })
                            ->helperText('The base price for the selected service'),

                        Forms\Components\Toggle::make('is_night_service')
                            ->label('Night Service (10 PM - 6 AM)')
                            ->disabled(fn($record) => $record !== null) // Disable during edit
                            ->live() // Use live() for real-time updates
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                // Recalculate totals when night service toggle changes
                                self::calculateTotals($get, $set);
                            })
                            ->helperText('Toggle this for services provided between 10 PM and 6 AM'),

                        Forms\Components\TextInput::make('night_tax')
                            ->label('Night Service Tax (SAR)')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(true) // Ensure this field is saved to database
                            ->helperText('Automatically calculated as 50% of base price for night services'),

                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Amount (SAR)')
                            ->numeric()
                            ->required()
                            ->disabled()
                            ->dehydrated(true) // Ensure this field is saved to database  
                            ->helperText(fn($record) => $record !== null ? 'Total amount cannot be modified after bill creation' : 'Base price + Night tax (if applicable)'),
                    ])->columns(2),


                Forms\Components\Section::make('Payment Information')
                    ->description('Only payment status can be updated after bill creation.')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Payment Status')
                            ->options([
                                'pending' => 'Pending Payment',
                                'paid' => 'Paid',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('pending')
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Service Notes')
                            ->helperText(fn($record) => $record !== null ? 'Notes cannot be modified after bill creation' : 'Add any additional notes about the service or charges')
                            ->disabled(fn($record) => $record !== null) // Disable during edit
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Bill #')
                    ->formatStateUsing(fn($state) => 'BILL-' . str_pad($state, 4, '0', STR_PAD_LEFT))
                    ->sortable(),

                Tables\Columns\TextColumn::make('serviceRequest.user.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Service')
                    ->sortable(),

                Tables\Columns\TextColumn::make('base_price')
                    ->label('Base Price')
                    ->formatStateUsing(fn($state) => 'SAR ' . number_format((float)$state, 2))
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_night_service')
                    ->label('Night Service')
                    ->boolean()
                    ->trueIcon('heroicon-o-moon')
                    ->falseIcon('heroicon-o-sun'),

                Tables\Columns\TextColumn::make('night_tax')
                    ->label('Night Tax')
                    ->formatStateUsing(fn($state) => 'SAR ' . number_format((float)$state, 2))
                    ->sortable()
                    ->color(fn($state) => $state > 0 ? 'warning' : 'gray'),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->formatStateUsing(fn($state) => 'SAR ' . number_format((float)$state, 2))
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'cancelled' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\TernaryFilter::make('is_night_service')
                    ->label('Night Service')
                    ->trueLabel('Night Service Only')
                    ->falseLabel('Day Service Only')
                    ->native(false),

                Tables\Filters\Filter::make('amount_range')
                    ->form([
                        Forms\Components\TextInput::make('amount_from')
                            ->label('Min Amount (SAR)')
                            ->numeric(),
                        Forms\Components\TextInput::make('amount_to')
                            ->label('Max Amount (SAR)')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['amount_from'],
                                fn(Builder $query, $amount): Builder => $query->where('total_amount', '>=', $amount),
                            )
                            ->when(
                                $data['amount_to'],
                                fn(Builder $query, $amount): Builder => $query->where('total_amount', '<=', $amount),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->status !== 'paid'), // Don't allow editing paid bills
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth('technician')->user()?->can('delete_bills')), // Add permission check if needed
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                // Show only bills created by current technician
                return $query->where('technician_id', auth('technician')->id());
            });
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
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),
            'view' => Pages\ListBills::route('/{record}'), // Fixed: should be ViewBill, not ListBills
            'edit' => Pages\EditBill::route('/{record}/edit'),
        ];
    }
}
