<?php

namespace App\Filament\Resources\ClassModels\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;

class ClassModelsTable
{
    public static function configure(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                // ✅ Professeur principal
                TextColumn::make('mainTeacher')
                    ->label('Professeur principal')
                    ->formatStateUsing(function ($record) {
                        // On récupère le premier professeur principal s’il existe
                        $mainTeacher = $record->mainTeacher()->first();
                        return $mainTeacher ? $mainTeacher->full_name ?? ($mainTeacher->first_name . ' ' . $mainTeacher->last_name) : 'Non défini';
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('academicLevel.name')
                    ->label('Niveau académique')
                    ->sortable(),

                TextColumn::make('capacity')
                    ->label('Capacité')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('school_fees')
                    ->label('Frais de scolarité')
                    ->money('XOF')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                TextColumn::make('enrollments_count')
                    ->label('Étudiants inscrits')
                    ->counts('enrollments')
                    ->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('academic_level_id')
                    ->label('Niveau académique')
                    ->relationship('academicLevel', 'name'),

                TernaryFilter::make('is_active')
                    ->label('Statut')
                    ->trueLabel('Actives seulement')
                    ->falseLabel('Inactives seulement')
                    ->native(false),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
        // return $table
        //     ->columns([
        //         TextColumn::make('name')
        //             ->searchable(),
        //         TextColumn::make('code')
        //             ->searchable(),
        //         TextColumn::make('academicLevel.name')
        //             ->searchable(),
        //         TextColumn::make('capacity')
        //             ->numeric()
        //             ->sortable(),
        //         TextColumn::make('school_fees')
        //             ->numeric()
        //             ->sortable(),
        //         IconColumn::make('is_active')
        //             ->boolean(),
        //         TextColumn::make('created_at')
        //             ->dateTime()
        //             ->sortable()
        //             ->toggleable(isToggledHiddenByDefault: true),
        //         TextColumn::make('updated_at')
        //             ->dateTime()
        //             ->sortable()
        //             ->toggleable(isToggledHiddenByDefault: true),
        //     ])
        //     ->filters([
        //         //
        //     ])
        //     ->recordActions([
        //         EditAction::make(),
        //     ])
        //     ->toolbarActions([
        //         BulkActionGroup::make([
        //             DeleteBulkAction::make(),
        //         ]),
        //     ]);
    }
}
