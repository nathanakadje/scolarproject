<?php

namespace App\Filament\Resources\Enrollments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\DeleteAction;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.student_number')
                    ->label('N° Étudiant')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('student.full_name')
                    ->label('Étudiant')
                    ->searchable(['student.first_name', 'student.last_name'])
                    ->sortable(),

                TextColumn::make('class.name')
                    ->label('Classe')
                    ->sortable(),

                TextColumn::make('academicYear.name')
                    ->label('Année académique')
                    ->sortable(),

                TextColumn::make('enrollment_date')
                    ->label('Date d\'inscription')
                    ->date()
                    ->sortable(),

                TextColumn::make('fees_due')
                    ->label('Frais dus')
                    ->money('XOF')
                    ->sortable(),

                TextColumn::make('fees_paid')
                    ->label('Frais payés')
                    ->money('XOF')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'success' => 'active',
                        'primary' => 'completed',
                        'warning' => 'transferred',
                        'danger' => 'dropped',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'active' => 'Active',
                        'completed' => 'Terminée',
                        'transferred' => 'Transférée',
                        'dropped' => 'Abandonnée',
                    }),
            ])
            ->filters([
                SelectFilter::make('class_id')
                    ->label('Classe')
                    ->relationship('class', 'name'),

                SelectFilter::make('academic_year_id')
                    ->label('Année académique')
                    ->relationship('academicYear', 'name'),

                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'active' => 'Active',
                        'completed' => 'Terminée',
                        'transferred' => 'Transférée',
                        'dropped' => 'Abandonnée',
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
        //         TextColumn::make('student.id')
        //             ->searchable(),
        //         TextColumn::make('class.name')
        //             ->searchable(),
        //         TextColumn::make('academicYear.name')
        //             ->searchable(),
        //         TextColumn::make('enrollment_date')
        //             ->date()
        //             ->sortable(),
        //         TextColumn::make('fees_paid')
        //             ->numeric()
        //             ->sortable(),
        //         TextColumn::make('fees_due')
        //             ->numeric()
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
