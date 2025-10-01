<?php

namespace App\Filament\Resources\ClassModels\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;


class ClassModelForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->schema([
                Section::make('Informations de la classe')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom de la classe')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('6ème A, CM2, etc.'),
                                TextInput::make('code')
                                    ->label('Code')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->alphaDash()
                                    ->placeholder('6A, CM2, etc.'),
                            ]),

                        Select::make('academic_level_id')
                            ->label('Niveau académique')
                            ->relationship('academicLevel', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('capacity')
                                    ->label('Capacité maximale')
                                    ->numeric()
                                    ->default(40)
                                    ->required()
                                    ->minValue(1)
                                    ->maxValue(100),

                                TextInput::make('school_fees')
                                    ->label('Frais de scolarité')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('CFA')
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label('Classe active')
                                    ->default(true),
                            ]),
                    ]),
            ]);
        // return $schema
        //     ->components([
        //         TextInput::make('name')
        //             ->required(),
        //         TextInput::make('code')
        //             ->required(),
        //         Select::make('academic_level_id')
        //             ->relationship('academicLevel', 'name')
        //             ->required(),
        //         TextInput::make('capacity')
        //             ->required()
        //             ->numeric()
        //             ->default(40),
        //         TextInput::make('school_fees')
        //             ->required()
        //             ->numeric()
        //             ->default(0),
        //         Toggle::make('is_active')
        //             ->required(),
        //     ]);
    }
}
