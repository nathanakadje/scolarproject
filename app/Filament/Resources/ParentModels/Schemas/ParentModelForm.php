<?php

namespace App\Filament\Resources\ParentModels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;

class ParentModelForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->schema([
                Section::make('Informations personnelles')
                    ->schema([
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

                        Select::make('relationship')
                            ->label('Lien de parenté')
                            ->options([
                                'father' => 'Père',
                                'mother' => 'Mère',
                                'guardian' => 'Tuteur/Tutrice',
                                'other' => 'Autre',
                            ])
                            ->required(),

                        TextInput::make('profession')
                            ->label('Profession')
                            ->maxLength(255),
                    ]),

                Section::make('Contact')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Téléphone principal')
                                    ->tel()
                                    ->required(),
                                TextInput::make('phone_2')
                                    ->label('Téléphone secondaire')
                                    ->tel(),
                            ]),

                        TextInput::make('email')
                            ->label('Email')
                            ->email(),

                        Textarea::make('address')
                            ->label('Adresse')
                            ->required()
                            ->rows(3),

                        Toggle::make('is_emergency_contact')
                            ->label('Contact d\'urgence')
                            ->default(false),
                    ]),
            ]);
        //     return $schema
        //         ->components([
        //             TextInput::make('first_name')
        //                 ->required(),
        //             TextInput::make('last_name')
        //                 ->required(),
        //             TextInput::make('relationship')
        //                 ->required(),
        //             TextInput::make('phone')
        //                 ->tel()
        //                 ->required(),
        //             TextInput::make('phone_2')
        //                 ->tel(),
        //             TextInput::make('email')
        //                 ->label('Email address')
        //                 ->email(),
        //             TextInput::make('profession'),
        //             Textarea::make('address')
        //                 ->required()
        //                 ->columnSpanFull(),
        //             Toggle::make('is_emergency_contact')
        //                 ->required(),
        //         ]);
    }
}
