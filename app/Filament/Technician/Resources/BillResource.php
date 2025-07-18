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
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $serviceRequest = ServiceRequest::with(['user', 'service', 'technician'])->find($state);
                                    if ($serviceRequest) {
                                        $set('user_id', $serviceRequest->user_id);
                                        $set('technician_id', $serviceRequest->technician_id);
                                        $set('service_id', $serviceRequest->service_id);
                                        $set('base_price', $serviceRequest->service->price);

                                        // Check if it's night service (10 PM - 6 AM)
                                        $isNightService = now()->hour >= 22 || now()->hour < 6;
                                        $set('is_night_service', $isNightService);

                                        // Calculate night tax (50% surcharge)
                                        $nightTax = $isNightService ? ($serviceRequest->service->price * 0.5) : 0;
                                        $set('night_tax', $nightTax);

                                        // Calculate total
                                        $set('total_amount', $serviceRequest->service->price + $nightTax);
                                    }
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
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $nightTax = $get('night_tax') ?? 0;
                                $set('total_amount', $state + $nightTax);
                            }),

                        Forms\Components\Toggle::make('is_night_service')
                            ->label('Night Service (10 PM - 6 AM)')
                            ->disabled(fn($record) => $record !== null) // Disable during edit
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $basePrice = $get('base_price') ?? 0;
                                $nightTax = $state ? ($basePrice * 0.5) : 0;
                                $set('night_tax', $nightTax);
                                $set('total_amount', $basePrice + $nightTax);
                            }),

                        Forms\Components\TextInput::make('night_tax')
                            ->label('Night Service Tax (SAR)')
                            ->numeric()
                            ->disabled()
                            ->helperText('Automatically calculated as 50% of base price for night services'),

                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Amount (SAR)')
                            ->numeric()
                            ->required()
                            ->disabled()
                            ->helperText(fn($record) => $record !== null ? 'Pricing cannot be modified after bill creation' : null),
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
                    ->formatStateUsing(fn($state) => 'SAR ' . number_format($state, 2))
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_night_service')
                    ->label('Night Service')
                    ->boolean(),

                Tables\Columns\TextColumn::make('night_tax')
                    ->label('Night Tax')
                    ->formatStateUsing(fn($state) => 'SAR ' . number_format($state, 2))
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->formatStateUsing(fn($state) => 'SAR ' . number_format($state, 2))
                    ->sortable()
                    ->weight('bold'),

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
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\TernaryFilter::make('is_night_service')
                    ->label('Night Service'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'view' => Pages\ListBills::route('/{record}'),
            'edit' => Pages\EditBill::route('/{record}/edit'),
        ];
    }
}
