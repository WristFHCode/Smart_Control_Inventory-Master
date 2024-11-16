<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Users Management';

    protected static ?string $label = 'User';

    protected static ?string $pluralLabel = 'Users';

    protected static ?int $navigationSort = 1000; // Nilai besar agar muncul di bagian bawah

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Form fields for creating or updating a user
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),

                TextInput::make('password')
                    ->required(fn ($record) => !$record) // Password required only when creating a new user
                    ->password() // Makes it show as a password field
                    ->minLength(8) // Minimum length of 8 characters
                    ->label('Password'),

                Select::make('roles')
                    ->multiple()
                    ->options(Role::all()->pluck('name', 'id'))
                    ->relationship('roles', 'name')
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Name'),

                TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->label('Email'),

                    TextColumn::make('roles.name')
                    ->label('Roles')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->badge(fn ($state) => $state && is_array($state) ? 'badge-' . strtolower(implode(', ', $state)) : 'badge-default')
                
            ])
            ->filters([
                // Custom filters can be added here
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
