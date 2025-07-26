<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $navigationGroup = 'User Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Account Settings')
                    ->schema([
                        Forms\Components\Select::make('role')
                            ->options([
                                'admin' => 'Administrator',
                                'client' => 'Client',
                            ])
                            ->required()
                            ->default('client'),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->helperText(
                                fn(string $context): string =>
                                $context === 'edit' ? 'Leave blank to keep current password' : ''
                            ),

                        Forms\Components\TextInput::make('password_confirmation')
                            ->password()
                            ->same('password')
                            ->required(fn(string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->dehydrated(false),
                    ])->columns(2),

                Forms\Components\Section::make('Timestamps')
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn(?User $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn(?User $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                    ])->columns(2)
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'danger',
                        'client' => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('service_requests_count')
                    ->label('Service Requests')
                    ->counts('serviceRequests')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Administrators',
                        'client' => 'Clients',
                    ]),

                Tables\Filters\Filter::make('verified')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('email_verified_at'))
                    ->label('Email Verified'),

                Tables\Filters\Filter::make('unverified')
                    ->query(fn(Builder $query): Builder => $query->whereNull('email_verified_at'))
                    ->label('Email Unverified'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn(User $record) => $record->role !== 'admin' || User::where('role', 'admin')->count() > 1),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function ($records) {
                            // Prevent deletion of all admin users
                            $adminUsers = $records->where('role', 'admin');
                            $totalAdmins = User::where('role', 'admin')->count();

                            if ($adminUsers->count() >= $totalAdmins) {
                                throw new \Exception('Cannot delete all admin users. At least one admin must remain.');
                            }

                            $records->each->delete();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ListUsers::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
