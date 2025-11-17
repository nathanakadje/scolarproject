<?php

namespace App\Filament\Resources\TimetableSessions\Schemas;

use Filament\Schemas\Schema;
use App\Models\TimetableSession;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use App\Models\Teacher;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Toggle;

class TimetableSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->schema([
                //
                Tabs::make('StudentDetails')
                    ->columnSpanFull() // ✅ force à prendre toute la largeur
                    ->tabs([
                        Tab::make('Informations personnelles')
                            ->schema([
                                Select::make('teacher_id')
                                    ->label('Enseignant')
                                    ->relationship(
                                        name: 'teacher',
                                        modifyQueryUsing: fn(Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                                    )
                                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                                    ->preload()
                                    ->searchable(['first_name', 'last_name'])->searchable()->required(),

                                Select::make('class_id')
                                    ->label('Classe')
                                    ->relationship('classe', 'name')
                                    ->required(),

                                Select::make('subject_id')
                                    ->label('Matière')
                                    ->relationship('subject', 'name')
                                    ->required(),

                                Select::make('day_of_week')
                                    ->label('Jour de la semaine')
                                    ->options([
                                        'monday' => 'Lundi',
                                        'tuesday' => 'Mardi',
                                        'wednesday' => 'Mercredi',
                                        'thursday' => 'Jeudi',
                                        'friday' => 'Vendredi',
                                        'saturday' => 'Samedi',
                                        'sunday' => 'Dimanche',
                                    ])
                                    ->required(),

                                TimePicker::make('start_time')
                                    ->label('Heure de début')
                                    ->required(),

                                TimePicker::make('end_time')
                                    ->label('Heure de fin')
                                    ->required(),

                                TextInput::make('room')
                                    ->label('Salle')
                                    ->required(),

                                TextInput::make('building')
                                    ->label('Bâtiment')
                                    ->nullable(),

                                DatePicker::make('valid_from')
                                    ->label('Valide à partir du')
                                    ->required(),

                                DatePicker::make('valid_until')
                                    ->label('Valide jusqu’au')
                                    ->nullable(),

                                Select::make('academic_year_id')
                                    ->label('Année académique')
                                    ->relationship('academicYear', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),

                                Select::make('semester')
                                    ->label('Semestre')
                                    ->options([
                                        '1' => 'Semestre 1',
                                        '2' => 'Semestre 2',
                                        '3' => 'Semestre 3',
                                    ])
                                    ->nullable(),

                                Select::make('session_type')
                                    ->label('Type de séance')
                                    ->options([
                                        'course' => 'Cours magistral',
                                        'td' => 'Travaux dirigés (TD)',
                                        'tp' => 'Travaux pratiques (TP)',
                                        'permanent' => 'Permanence',
                                        'support' => 'Soutien',
                                    ])
                                    ->default('course'),

                                Toggle::make('is_active')
                                    ->label('Actif')
                                    ->default(true),

                                Textarea::make('notes')
                                    ->label('Remarques')
                                    ->columnSpanFull(),
                            ])->columns(2)

                    ])
            ]);

    }
}
