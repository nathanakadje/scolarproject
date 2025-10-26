<?php

namespace App\Filament\Resources\AdministrativeDeadlines\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class AdministrativeDeadlineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([

                Tabs::make('AdministrativeDeadlineTabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Détails de l’échéance')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Titre')
                                            ->required()
                                            ->maxLength(255),

                                        Textarea::make('description')
                                            ->label('Description')
                                            ->rows(3),

                                        DatePicker::make('deadline_date')
                                            ->label('Date limite')
                                            ->required(),

                                        TimePicker::make('deadline_time')
                                            ->label('Heure limite')
                                            ->nullable(),

                                        Select::make('category')
                                            ->label('Catégorie')
                                            ->options([
                                                'grades_submission' => 'Saisie des notes',
                                                'reports' => 'Rapports',
                                                'bulletin_closure' => 'Clôture des bulletins',
                                                'meeting' => 'Réunion obligatoire',
                                                'document_submission' => 'Dépôt de documents',
                                                'planning' => 'Planning',
                                            ])
                                            ->required(),

                                        Select::make('priority')
                                            ->label('Priorité')
                                            ->options([
                                                'low' => 'Basse',
                                                'medium' => 'Moyenne',
                                                'high' => 'Haute',
                                                'urgent' => 'Urgente',
                                            ])
                                            ->default('high'),

                                        Toggle::make('is_mandatory')
                                            ->label('Obligatoire')
                                            ->default(true),
                                    ]),
                            ]),

                        Tab::make('Professeurs concernés')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Select::make('concerned_teachers')
                                            ->label('Professeurs')
                                            ->multiple()
                                            ->options(
                                                \App\Models\Teacher::all()
                                                    ->mapWithKeys(fn($teacher) => [
                                                        $teacher->id => "{$teacher->first_name} {$teacher->last_name}"
                                                    ])
                                            )
                                            ->preload()
                                            ->searchable(),
                                    ])
                                    ->collapsed(),
                            ]),
                    ])

            ]);
    }
}
