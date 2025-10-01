<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\DeleteAction;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('teacher_number')
                    ->label('N° Enseignant')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('full_name')
                    ->label('Nom complet')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('phone')
                    ->label('Téléphone')
                    ->searchable(),

                TextColumn::make('qualification')
                    ->label('Qualification')
                    ->limit(30),

                BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'inactive',
                        'secondary' => 'retired',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'active' => 'Actif',
                        'inactive' => 'Inactif',
                        'retired' => 'Retraité',
                    }),

                TextColumn::make('hire_date')
                    ->label('Date d\'embauche')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'active' => 'Actif',
                        'inactive' => 'Inactif',
                        'retired' => 'Retraité',
                    ]),
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
    }

    //     return $table
    //         ->columns([
    //             TextColumn::make('teacher_number')
    //                 ->searchable(),
    //             TextColumn::make('first_name')
    //                 ->searchable(),
    //             TextColumn::make('last_name')
    //                 ->searchable(),
    //             TextColumn::make('birth_date')
    //                 ->date()
    //                 ->sortable(),
    //             TextColumn::make('gender')
    //                 ->searchable(),
    //             TextColumn::make('phone')
    //                 ->searchable(),
    //             TextColumn::make('email')
    //                 ->label('Email address')
    //                 ->searchable(),
    //             TextColumn::make('qualification')
    //                 ->searchable(),
    //             TextColumn::make('hire_date')
    //                 ->date()
    //                 ->sortable(),
    //             TextColumn::make('salary')
    //                 ->numeric()
    //                 ->sortable(),
    //             TextColumn::make('status')
    //                 ->searchable(),
    //             TextColumn::make('photo')
    //                 ->searchable(),
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
