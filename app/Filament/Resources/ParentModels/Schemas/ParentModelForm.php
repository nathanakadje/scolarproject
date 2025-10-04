<?php

namespace App\Filament\Resources\ParentModels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\ParentModel;

class ParentModelForm
{
    public static function configure(Schema $schema): Schema
    {

        return $schema
            ->schema([
                Tabs::make('ParentsDetails')
                    ->columnSpanFull() // ✅ force à prendre toute la largeur
                    ->tabs([
                        Tab::make('Informations personnelles')
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
                            ]),
                        Tab::make('Students')
                            ->schema(components: [
                                Select::make('students')
                                    ->label('students')
                                    ->multiple() // plusieurs parents possibles
                                    ->relationship(
                                        name: 'students',
                                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                                    )
                                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->first_name} {$record->last_name}")
                                    ->searchable(['first_name', 'last_name'])
                                    ->preload()
                                    ->createOptionForm([ // Formulaire de création rapide d’un parent
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


                                            ])
                                    ]),


                                // ->createOptionUsing(function (array $data, $field) {
                                //     // Créez le parent
                                //     $parent = Student::create($data);

                                //     // Rattachez immédiatement ce parent au student créé en cours
                                //     // $field->getLivewire() récupère la Livewire du formulaire
                                //     $student = ParentModel::find(request()->route('record'));

                                //     if ($student) {
                                //         $student->parents()->attach($parent->id, [
                                //             'relationship' => $data['relationship'],
                                //             'is_primary_contact' => $data['is_emergency_contact'] ?? false,
                                //         ]);
                                //     }
                                //     return $parent->id;
                                // }),
                            ]),
                    ]),
            ]);

    }
}
