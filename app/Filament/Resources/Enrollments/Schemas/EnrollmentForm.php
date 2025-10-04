<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use App\Models\AcademicYear;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Inscription')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('student_id')
                                    ->label('Étudiant')
                                    ->relationship('student', 'first_name')
                                    ->getOptionLabelFromRecordUsing(fn($record) => $record->full_name . ' (' . $record->student_number . ')')
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                Select::make('class_id')
                                    ->label('Classe')
                                    ->relationship('class', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('academic_year_id')
                                    ->label('Année académique')
                                    ->relationship('academicYear', 'name')
                                    ->required()
                                    ->default(function () {
                                        return AcademicYear::where('is_current', true)->first()?->id;
                                    }),

                                DatePicker::make('enrollment_date')
                                    ->label('Date d\'inscription')
                                    ->required()
                                    ->default(now()),
                            ]),
                    ]),

                Section::make('Frais de scolarité')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('fees_due')
                                    ->label('Frais dus')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('CFA')
                                    ->required(),

                                TextInput::make('fees_paid')
                                    ->label('Frais payés')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('CFA')
                                    ->required(),

                                Select::make('status')
                                    ->label('Statut')
                                    ->options([
                                        'active' => 'Active',
                                        'completed' => 'Terminée',
                                        'transferred' => 'Transférée',
                                        'dropped' => 'Abandonnée',
                                    ])
                                    ->default('active')
                                    ->required(),
                            ]),

                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3),
                    ]),
            ]);
        // return $schema
        //     ->components([
        //         Select::make('student_id')
        //             ->relationship('student', 'id')
        //             ->required(),
        //         Select::make('class_id')
        //             ->relationship('class', 'name')
        //             ->required(),
        //         Select::make('academic_year_id')
        //             ->relationship('academicYear', 'name')
        //             ->required(),
        //         DatePicker::make('enrollment_date')
        //             ->required(),
        //         TextInput::make('fees_paid')
        //             ->required()
        //             ->numeric()
        //             ->default(0),
        //         TextInput::make('fees_due')
        //             ->required()
        //             ->numeric()
        //             ->default(0),
        //         TextInput::make('status')
        //             ->required()
        //             ->default('active'),
        //         Textarea::make('notes')
        //             ->columnSpanFull(),
        //     ]);
    }
}
