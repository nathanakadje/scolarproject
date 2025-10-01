<?php

namespace App\Filament\Resources\Subjects\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\ColorPicker;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->schema([
                Section::make('Informations de la matière')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom de la matière')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('code')
                                    ->label('Code')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->alphaDash(),
                            ]),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('coefficient')
                                    ->label('Coefficient')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->minValue(1)
                                    ->maxValue(10),

                                ColorPicker::make('color')
                                    ->label('Couleur')
                                    ->default('#3490dc'),

                                Toggle::make('is_active')
                                    ->label('Matière active')
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
        //         Textarea::make('description')
        //             ->columnSpanFull(),
        //         TextInput::make('coefficient')
        //             ->required()
        //             ->numeric()
        //             ->default(1),
        //         TextInput::make('color')
        //             ->required()
        //             ->default('#3490dc'),
        //         Toggle::make('is_active')
        //             ->required(),
        //     ]);
    }
}
