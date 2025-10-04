<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Models\Teacher;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Select;
use App\Models\TeacherClassAssignment;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;

class TeacherForm
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
                                Tabs::make('TeacherDetails')
                                    ->columnSpanFull() // ✅ force à prendre toute la largeur
                                    ->tabs([
                                        Tab::make('Informations personnelles')
                                            ->schema([
                                                Section::make('Informations personnelles')
                                                    ->schema([
                                                        TextInput::make('teacher_number')
                                                            ->label('Numéro professeur')
                                                            ->readOnly()
                                                            ->required()
                                                            ->unique(ignoreRecord: true)
                                                            ->default(fn() => 'TEA' . now()->year . str_pad(Teacher::count() + 1, 4, '0', STR_PAD_LEFT)),

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
                                            ]),
                                    ]),
                            ]),
                        Tab::make('Affectations')
                            ->schema([
                                Repeater::make('classAssignments')
                                    ->label('Affectations')
                                    ->relationship('classAssignments') // Relation hasMany dans le modèle Teacher
                                    ->schema([
                                        // Classe
                                        Select::make('class_id')
                                            ->label('Class')
                                            ->relationship('class', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        // Matière
                                        Select::make('subject_id')
                                            ->label('subjects')
                                            ->relationship('subject', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        // Année académique
                                        Select::make('academic_year_id')
                                            ->label('Academic Year')
                                            ->relationship('academicYear', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),

                                        // Professeur principal
                                        // Toggle::make('is_main_teacher')
                                        //     ->label('Professeur principal ?')
                                        //     ->reactive()
                                        //     ->afterStateUpdated(function ($state, callable $set, callable $get, $livewire) {
                                        //         if ($state) {
                                        //             $exists = TeacherClassAssignment::where('class_id', $get('class_id'))
                                        //                 ->where('is_main_teacher', true)
                                        //                 ->when($get('subject_id'), fn($query) => $query->where('subject_id', $get('subject_id')))
                                        //                 ->when($get('academic_year_id'), fn($query) => $query->where('academic_year_id', $get('academic_year_id')))
                                        //                 ->exists();

                                        //             if ($exists) {
                                        //                 $set('is_main_teacher', false);
                                        //                 $livewire->notify('danger', 'Un professeur principal est déjà défini pour cette classe.');
                                        //             }
                                        //         }
                                        //     })
                                        Toggle::make('is_main_teacher')
                                            ->label('Professeur principal ?')
                                            ->reactive()
                                            ->live()
                                            ->afterStateUpdated(function ($state, callable $set, $get, $livewire) {
                                                if ($state) {
                                                    $exists = TeacherClassAssignment::where('class_id', $get('class_id'))
                                                        ->where('is_main_teacher', true)
                                                        ->exists();

                                                    if ($exists) {
                                                        $set('is_main_teacher', false);
                                                        Notification::make()
                                                            ->title('Un professeur principal est déjà défini pour cette classe.')
                                                            ->danger()
                                                            ->send();
                                                    }
                                                }
                                            })

                                    ])
                                    ->columns(2)
                                    ->defaultItems(1)
                            ]),
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
