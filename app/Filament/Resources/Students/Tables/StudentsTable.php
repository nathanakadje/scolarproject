<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;


class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student_number')
                    ->label('N° Étudiant')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('full_name')
                    ->label('Nom complet')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),

                TextColumn::make('birth_date')
                    ->label('Date de naissance')
                    ->date()
                    ->sortable(),

                TextColumn::make('gender')
                    ->label('Genre')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'M' => 'Masculin',
                        'F' => 'Féminin',
                    }),

                BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'suspended',
                        'primary' => 'graduated',
                        'danger' => 'dropped',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'active' => 'Actif',
                        'suspended' => 'Suspendu',
                        'graduated' => 'Diplômé',
                        'dropped' => 'Abandonné',
                    }),
                TextColumn::make('classe.name')
                    ->label('Classe')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('enrollment_date')
                    ->label('Date d\'inscription')
                    ->date()
                    ->sortable(),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'active' => 'Actif',
                        'suspended' => 'Suspendu',
                        'graduated' => 'Diplômé',
                        'dropped' => 'Abandonné',
                    ]),

                SelectFilter::make('gender')
                    ->label('Genre')
                    ->options([
                        'M' => 'Masculin',
                        'F' => 'Féminin',
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
        // return $table
        //     ->columns([
        //         TextColumn::make('student_number')
        //             ->searchable(),
        //         TextColumn::make('first_name')
        //             ->searchable(),
        //         TextColumn::make('last_name')
        //             ->searchable(),
        //         TextColumn::make('birth_date')
        //             ->date()
        //             ->sortable(),
        //         TextColumn::make('birth_place')
        //             ->searchable(),
        //         TextColumn::make('gender')
        //             ->searchable(),
        //         TextColumn::make('nationality')
        //             ->searchable(),
        //         TextColumn::make('phone')
        //             ->searchable(),
        //         TextColumn::make('email')
        //             ->label('Email address')
        //             ->searchable(),
        //         TextColumn::make('photo')
        //             ->searchable(),
        //         TextColumn::make('enrollment_date')
        //             ->date()
        //             ->sortable(),
        //         TextColumn::make('status')
        //             ->searchable(),
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
