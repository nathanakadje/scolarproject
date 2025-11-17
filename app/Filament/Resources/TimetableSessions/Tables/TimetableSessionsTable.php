<?php

namespace App\Filament\Resources\TimetableSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
class TimetableSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('classe.name')->label('Classe')->sortable(),
                TextColumn::make('subject.name')->label('Matière')->sortable(),
                TextColumn::make('teacher.full_name')
                    ->label('Enseignant')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),
                TextColumn::make('day_of_week')->label('Jour'),
                TextColumn::make('start_time')->label('Début'),
                TextColumn::make('end_time')->label('Fin'),
                TextColumn::make('academicYear.name') // "academicYear" au lieu de "academic_year"
                    ->label('Année académique')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Actif'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
