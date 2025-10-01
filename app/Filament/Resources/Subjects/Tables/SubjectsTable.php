<?php

namespace App\Filament\Resources\Subjects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\DeleteAction;

class SubjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('color')
                    ->label('Couleur'),

                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('coefficient')
                    ->label('Coefficient')
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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

        //     return $table
        //         ->columns([
        //             TextColumn::make('name')
        //                 ->searchable(),
        //             TextColumn::make('code')
        //                 ->searchable(),
        //             TextColumn::make('coefficient')
        //                 ->numeric()
        //                 ->sortable(),
        //             TextColumn::make('color')
        //                 ->searchable(),
        //             IconColumn::make('is_active')
        //                 ->boolean(),
        //             TextColumn::make('created_at')
        //                 ->dateTime()
        //                 ->sortable()
        //                 ->toggleable(isToggledHiddenByDefault: true),
        //             TextColumn::make('updated_at')
        //                 ->dateTime()
        //                 ->sortable()
        //                 ->toggleable(isToggledHiddenByDefault: true),
        //         ])
        //         ->filters([
        //             //
        //         ])
        //         ->recordActions([
        //             EditAction::make(),
        //         ])
        //         ->toolbarActions([
        //             BulkActionGroup::make([
        //                 DeleteBulkAction::make(),
        //             ]),
        //         ]);
    }
}
