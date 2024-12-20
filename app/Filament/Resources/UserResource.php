<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\UserResource\Pages;

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
            Fieldset::make('User Details') // Membuat grup untuk form
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
        
                    TextInput::make('email')
                        ->required()
                        ->email()
                        ->maxLength(255),
        
                    TextInput::make('password')
                        ->required(fn ($record) => !$record) // Password hanya wajib saat membuat user baru
                        ->password() // Menjadikan field password
                        ->minLength(8)
                        ->label('Password'),
        
                    Select::make('roles')
                        ->relationship('roles', 'name') // Menarik data dari relationship
                        ->required(),
                ])
                ->columns(1), // Atur fieldset menjadi 1 kolom
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
