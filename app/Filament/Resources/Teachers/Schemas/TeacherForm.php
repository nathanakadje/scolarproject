<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Select;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informations personnelles')
                    ->schema([
                        TextInput::make('teacher_number')
                            ->label('Numéro enseignant')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('Prénom')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('last_name')
                                    ->label('Nom')
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        Grid::make(3)
                            ->schema([
                                DatePicker::make('birth_date')
                                    ->label('Date de naissance')
                                    ->required(),
                                Select::make('gender')
                                    ->label('Genre')
                                    ->options([
                                        'M' => 'Masculin',
                                        'F' => 'Féminin',
                                    ])
                                    ->required(),
                                Select::make('status')
                                    ->label('Statut')
                                    ->options([
                                        'active' => 'Actif',
                                        'inactive' => 'Inactif',
                                        'retired' => 'Retraité',
                                    ])
                                    ->default('active')
                                    ->required(),
                            ]),
                    ]),

                Section::make('Contact et informations professionnelles')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Téléphone')
                                    ->tel()
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true),
                            ]),

                        Textarea::make('address')
                            ->label('Adresse')
                            ->required()
                            ->rows(3),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('qualification')
                                    ->label('Diplôme/Qualification')
                                    ->required()
                                    ->maxLength(255),
                                DatePicker::make('hire_date')
                                    ->label('Date d\'embauche')
                                    ->required(),
                            ]),

                        TextInput::make('salary')
                            ->label('Salaire')
                            ->numeric()
                            ->prefix('CFA'),

                        TagsInput::make('specializations')
                            ->label('Spécialisations')
                            ->placeholder('Mathématiques, Physique, etc.'),
                    ]),
            ]);
        // return $schema
        //     ->components([
        //         TextInput::make('teacher_number')
        //             ->required(),
        //         TextInput::make('first_name')
        //             ->required(),
        //         TextInput::make('last_name')
        //             ->required(),
        //         DatePicker::make('birth_date')
        //             ->required(),
        //         TextInput::make('gender')
        //             ->required(),
        //         TextInput::make('phone')
        //             ->tel()
        //             ->required(),
        //         TextInput::make('email')
        //             ->label('Email address')
        //             ->email()
        //             ->required(),
        //         Textarea::make('address')
        //             ->required()
        //             ->columnSpanFull(),
        //         TextInput::make('qualification')
        //             ->required(),
        //         DatePicker::make('hire_date')
        //             ->required(),
        //         TextInput::make('salary')
        //             ->numeric(),
        //         TextInput::make('status')
        //             ->required()
        //             ->default('active'),
        //         TextInput::make('photo'),
        //         Textarea::make('specializations')
        //             ->columnSpanFull(),
        //     ]);
    }
}
