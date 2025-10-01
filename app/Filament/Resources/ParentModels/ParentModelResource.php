<?php

namespace App\Filament\Resources\ParentModels;

use App\Filament\Resources\ParentModels\Pages\CreateParentModel;
use App\Filament\Resources\ParentModels\Pages\EditParentModel;
use App\Filament\Resources\ParentModels\Pages\ListParentModels;
use App\Filament\Resources\ParentModels\Schemas\ParentModelForm;
use App\Filament\Resources\ParentModels\Tables\ParentModelsTable;
use App\Models\ParentModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParentModelResource extends Resource
{
    protected static ?string $model = ParentModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ParentModelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParentModelsTable::configure($table);
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
            'index' => ListParentModels::route('/'),
            'create' => CreateParentModel::route('/create'),
            'edit' => EditParentModel::route('/{record}/edit'),
        ];
    }
}
