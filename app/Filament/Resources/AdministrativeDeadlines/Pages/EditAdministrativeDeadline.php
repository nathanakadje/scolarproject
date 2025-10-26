<?php

namespace App\Filament\Resources\AdministrativeDeadlines\Pages;

use App\Filament\Resources\AdministrativeDeadlines\AdministrativeDeadlineResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdministrativeDeadline extends EditRecord
{
    protected static string $resource = AdministrativeDeadlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
