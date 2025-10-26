<?php

namespace App\Filament\Resources\AdministrativeDeadlines\Tables;


use Filament\Tables\Columns\BadgeColumn;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class AdministrativeDeadlinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Titre')->searchable()->sortable(),
                TextColumn::make('category')->label('Catégorie')->badge(),
                TextColumn::make('priority')->label('Priorité')->badge(),
                IconColumn::make('is_mandatory')
                    ->label('Obligatoire')
                    ->boolean(),
                TextColumn::make('deadline_date')
                    ->label('Date limite')
                    ->date()
                    ->sortable(),
                TextColumn::make('deadline_time')
                    ->label('Heure')
                    ->time(),
                TextColumn::make('creator.name')
                    ->label('Créé par')
                    ->sortable(),
                BadgeColumn::make('priority')
                    ->label('Priorité')
                    ->colors([
                        'success' => 'low',
                        'warning' => 'medium',
                        'danger' => 'high',
                        'fuchsia' => 'urgent',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'low' => 'Basse',
                        'medium' => 'Moyenne',
                        'high' => 'Haute',
                        'urgent' => 'Urgente',
                    }),
            ])

            ->filters([
                SelectFilter::make('category')
                    ->label('Catégorie')
                    ->options([
                        'grades_submission' => 'Saisie des notes',
                        'reports' => 'Rapports',
                        'bulletin_closure' => 'Clôture des bulletins',
                        'meeting' => 'Réunion obligatoire',
                        'document_submission' => 'Dépôt de documents',
                        'planning' => 'Planning',
                    ]),
                SelectFilter::make('priority')
                    ->label('Priorité')
                    ->options([
                        'low' => 'Basse',
                        'medium' => 'Moyenne',
                        'high' => 'Haute',
                        'urgent' => 'Urgente',
                    ]),

            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
