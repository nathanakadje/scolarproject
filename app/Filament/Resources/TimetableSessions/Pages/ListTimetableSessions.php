<?php

namespace App\Filament\Resources\TimetableSessions\Pages;

use App\Filament\Resources\TimetableSessions\TimetableSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTimetableSessions extends ListRecords
{
    protected static string $resource = TimetableSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
