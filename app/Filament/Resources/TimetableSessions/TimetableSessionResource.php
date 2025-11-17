<?php

namespace App\Filament\Resources\TimetableSessions;

use App\Filament\Resources\TimetableSessions\Pages\CreateTimetableSession;
use App\Filament\Resources\TimetableSessions\Pages\EditTimetableSession;
use App\Filament\Resources\TimetableSessions\Pages\ListTimetableSessions;
use App\Filament\Resources\TimetableSessions\Schemas\TimetableSessionForm;
use App\Filament\Resources\TimetableSessions\Tables\TimetableSessionsTable;
use App\Models\TimetableSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TimetableSessionResource extends Resource
{
    protected static ?string $model = TimetableSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TimetableSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TimetableSessionsTable::configure($table);
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
            'index' => ListTimetableSessions::route('/'),
            'create' => CreateTimetableSession::route('/create'),
            'edit' => EditTimetableSession::route('/{record}/edit'),
        ];
    }
}
