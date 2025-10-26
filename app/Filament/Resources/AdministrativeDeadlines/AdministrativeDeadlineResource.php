<?php

namespace App\Filament\Resources\AdministrativeDeadlines;

use App\Filament\Resources\AdministrativeDeadlines\Pages\CreateAdministrativeDeadline;
use App\Filament\Resources\AdministrativeDeadlines\Pages\EditAdministrativeDeadline;
use App\Filament\Resources\AdministrativeDeadlines\Pages\ListAdministrativeDeadlines;
use App\Filament\Resources\AdministrativeDeadlines\Schemas\AdministrativeDeadlineForm;
use App\Filament\Resources\AdministrativeDeadlines\Tables\AdministrativeDeadlinesTable;
use App\Models\AdministrativeDeadline;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdministrativeDeadlineResource extends Resource
{
    protected static ?string $model = AdministrativeDeadline::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AdministrativeDeadlineForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdministrativeDeadlinesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdministrativeDeadlines::route('/'),
            'create' => CreateAdministrativeDeadline::route('/create'),
            'edit' => EditAdministrativeDeadline::route('/{record}/edit'),
        ];
    }

}
