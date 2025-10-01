<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use App\Models\Student;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('StudentDetails')
                    ->columnSpanFull() // ✅ force à prendre toute la largeur
                    ->tabs([
                        Tab::make('Informations personnelles')
                            ->schema([
                                Section::make('Informations personnelles')
                                    ->schema([
                                        TextInput::make('student_number')
                                            ->label('Numéro étudiant')
                                            ->readOnly()
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->default(fn() => 'STU' . now()->year . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT)),
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
                                                TextInput::make('birth_place')
                                                    ->label('Lieu de naissance')
                                                    ->required(),
                                                Select::make('gender')
                                                    ->label('Genre')
                                                    ->options([
                                                        'M' => 'Masculin',
                                                        'F' => 'Féminin',
                                                    ])
                                                    ->required(),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('nationality')
                                                    ->label('Nationalité')
                                                    ->default('Ivoirienne')
                                                    ->required(),
                                                Select::make('status')
                                                    ->label('Statut')
                                                    ->options([
                                                        'active' => 'Actif',
                                                        'suspended' => 'Suspendu',
                                                        'graduated' => 'Diplômé',
                                                        'dropped' => 'Abandonné',
                                                    ])
                                                    ->default('active')
                                                    ->required(),
                                            ]),
                                    ]),

                                Section::make('Contact et adresse')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('phone')
                                                    ->label('Téléphone')
                                                    ->tel(),
                                                TextInput::make('email')
                                                    ->label('Email')
                                                    ->email(),
                                            ]),

                                        Textarea::make('address')
                                            ->label('Adresse')
                                            ->required()
                                            ->rows(3),
                                    ]),

                                Section::make('Informations académiques')
                                    ->schema([
                                        DatePicker::make('enrollment_date')
                                            ->label('Date d\'inscription')
                                            ->required()
                                            ->default(now()),

                                        Textarea::make('medical_info')
                                            ->label('Informations médicales')
                                            ->rows(3),

                                        Textarea::make('notes')
                                            ->label('Notes')
                                            ->rows(3),
                                    ]),
                            ]),

                        Tab::make('Parents')
                            ->schema([
                                Select::make('parents')
                                    ->label('Parents')
                                    ->multiple() // plusieurs parents possibles
                                    ->relationship(
                                        name: 'parents',
                                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                                    )
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->first_name} {$record->last_name}")
                                    ->searchable(['first_name', 'last_name'])
                                    ->preload()
                                    ->createOptionForm([ // Formulaire de création rapide d’un parent
                                        TextInput::make('first_name')
                                            ->label('Prénom')
                                            ->required(),
                                        TextInput::make('last_name')
                                            ->label('Nom')
                                            ->required(),
                                        TextInput::make('phone')
                                            ->label('Téléphone')
                                            ->tel()
                                            ->required(),
                                        TextInput::make('email')
                                            ->label('Email')
                                            ->email(),
                                        Textarea::make('address')
                                            ->label('Adresse')
                                            ->rows(2),
                                        Select::make('relationship')
                                            ->label('Relation')
                                            ->options([
                                                'father' => 'Père',
                                                'mother' => 'Mère',
                                                'guardian' => 'Tuteur/Tutrice',
                                                'other' => 'Autre',
                                            ])
                                            ->required(),
                                        Toggle::make('is_emergency_contact')
                                            ->label('Contact d\'urgence')
                                            ->default(false),
                                    ]),
                            ]),
                        Tab::make('Enrollments & Grades')
                            ->schema([
                                DatePicker::make('enrollment_date')
                                    ->label('Date d’inscription')
                                    ->default(now())
                                    ->required(),
                                // Repeater::make('grades')
                                //     ->relationship()
                                //     ->schema([
                                //         Select::make('evaluation_id')
                                //             ->label('Évaluation')
                                //             ->options(Evaluation::all()->pluck('name', 'id'))
                                //             ->required(),
                                //         TextInput::make('score')
                                //             ->label("Note obtenue")
                                //             ->numeric()
                                //             ->required(),
                                //         Textarea::make('feedback')
                                //             ->label('Commentaires'),
                                //     ])
                                //     ->createItemButtonLabel('Ajouter une note'),
                            ]),

                    ]),
            ]);
        //     return $schema
        //         ->components([
        //             TextInput::make('student_number')
        //                 ->required(),
        //             TextInput::make('first_name')
        //                 ->required(),
        //             TextInput::make('last_name')
        //                 ->required(),
        //             DatePicker::make('birth_date')
        //                 ->required(),
        //             TextInput::make('birth_place')
        //                 ->required(),
        //             TextInput::make('gender')
        //                 ->required(),
        //             TextInput::make('nationality')
        //                 ->required()
        //                 ->default('Ivoirienne'),
        //             TextInput::make('phone')
        //                 ->tel(),
        //             TextInput::make('email')
        //                 ->label('Email address')
        //                 ->email(),
        //             Textarea::make('address')
        //                 ->required()
        //                 ->columnSpanFull(),
        //             TextInput::make('photo'),
        //             DatePicker::make('enrollment_date')
        //                 ->required(),
        //             TextInput::make('status')
        //                 ->required()
        //                 ->default('active'),
        //             Textarea::make('medical_info')
        //                 ->columnSpanFull(),
        //             Textarea::make('notes')
        //                 ->columnSpanFull(),
        //         ]);


    }
}
