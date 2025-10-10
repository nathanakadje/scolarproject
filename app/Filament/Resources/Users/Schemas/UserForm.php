<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Inscription')
                    ->columnSpanFull() // ✅ force à prendre toute la largeu
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom complet')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label('Email address')
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->required(),
                                DateTimePicker::make('email_verified_at'),
                                TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                                    ->required(fn(string $context) => $context === 'create')
                                    ->label('Mot de passe'),
                                Select::make('roles')
                                    ->label('Rôles')
                                    ->multiple()
                                    ->preload()
                                    ->relationship('roles', 'name') // liaison Spatie
                                    ->options(Role::all()->pluck('name', 'id'))
                                    ->helperText('Sélectionnez un ou plusieurs rôles pour cet utilisateur.'),
                                // TextInput::make('current_team_id')
                                //     ->numeric(),
                                ImageColumn::make('avatar')
                                    ->imageHeight(40)
                                    ->circular()
                                // Textarea::make('two_factor_secret')
                                //     ->columnSpanFull(),
                                // Textarea::make('two_factor_recovery_codes')
                                //     ->columnSpanFull(),
                                // DateTimePicker::make('two_factor_confirmed_at'),
                            ]),
                    ])

            ]);
        // return $schema
        //     ->components([
        //         TextInput::make('name')
        //             ->label('Nom complet')
        //             ->required()
        //             ->maxLength(255),
        //         TextInput::make('email')
        //             ->label('Email address')
        //             ->email()
        //             ->unique(ignoreRecord: true)
        //             ->required(),
        //         DateTimePicker::make('email_verified_at'),
        //         TextInput::make('password')
        //             ->password()
        //             ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
        //             ->required(fn(string $context) => $context === 'create')
        //             ->label('Mot de passe'),
        //         Select::make('roles')
        //             ->label('Rôles')
        //             ->multiple()
        //             ->preload()
        //             ->relationship('roles', 'name') // liaison Spatie
        //             ->options(Role::all()->pluck('name', 'name'))
        //             ->helperText('Sélectionnez un ou plusieurs rôles pour cet utilisateur.'),
        //         // TextInput::make('current_team_id')
        //         //     ->numeric(),
        //         TextInput::make('profile_photo_path'),
        //         Textarea::make('two_factor_secret')
        //             ->columnSpanFull(),
        //         Textarea::make('two_factor_recovery_codes')
        //             ->columnSpanFull(),
        //         DateTimePicker::make('two_factor_confirmed_at'),
        //     ]);
    }
}
