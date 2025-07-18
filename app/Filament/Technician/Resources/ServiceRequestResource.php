<?php

namespace App\Filament\Technician\Resources;

use App\Filament\Technician\Resources\ServiceRequestResource\Pages;
use App\Models\ServiceRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->label('Update Status')
                    ->visible(fn($record) => $record->status !== 'completed'),

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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // No bulk delete for service requests
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
            'index' => Pages\ListServiceRequests::route('/'),
            'view' => Pages\ListServiceRequests::route('/{record}'), // Back to original
            'edit' => Pages\EditServiceRequest::route('/{record}/edit'),
        ];
    }
}
