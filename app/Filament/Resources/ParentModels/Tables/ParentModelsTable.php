<?php

namespace App\Filament\Resources\ParentModels\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\DeleteAction;

class ParentModelsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Nom complet')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),

                BadgeColumn::make('relationship')
                    ->label('Relation')
                    ->colors([
                        'primary' => 'father',
                        'teal' => 'mother',
                        'warning' => 'guardian',
                        'fuchsia' => 'other',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'father' => 'Père',
                        'mother' => 'Mère',
                        'guardian' => 'Tuteur/Tutrice',
                        'other' => 'Autre',
                    }),

                TextColumn::make('phone')
                    ->label('Téléphone')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('profession')
                    ->label('Profession')
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_emergency_contact')
                    ->label('Contact d\'urgence')
                    ->boolean(),

                TextColumn::make('students_count')
                    ->label('Nombre d\'enfants')
                    ->counts('students')
                    ->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('relationship')
                    ->label('Relation')
                    ->options([
                        'father' => 'Père',
                        'mother' => 'Mère',
                        'guardian' => 'Tuteur/Tutrice',
                        'other' => 'Autre',
                    ]),

                TernaryFilter::make('is_emergency_contact')
                    ->label('Contact d\'urgence')
                    ->trueLabel('Contacts d\'urgence')
                    ->falseLabel('Non contacts d\'urgence')
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
        //         TextColumn::make('first_name')
        //             ->searchable(),
        //         TextColumn::make('last_name')
        //             ->searchable(),
        //         TextColumn::make('relationship')
        //             ->searchable(),
        //         TextColumn::make('phone')
        //             ->searchable(),
        //         TextColumn::make('phone_2')
        //             ->searchable(),
        //         TextColumn::make('email')
        //             ->label('Email address')
        //             ->searchable(),
        //         TextColumn::make('profession')
        //             ->searchable(),
        //         IconColumn::make('is_emergency_contact')
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
