<?php

namespace App\Filament\Resources\TimetableSessions\Pages;

use App\Filament\Resources\TimetableSessions\TimetableSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTimetableSession extends EditRecord
{
    protected static string $resource = TimetableSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
