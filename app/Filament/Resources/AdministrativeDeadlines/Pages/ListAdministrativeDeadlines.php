<?php

namespace App\Filament\Resources\AdministrativeDeadlines\Pages;

use App\Filament\Resources\AdministrativeDeadlines\AdministrativeDeadlineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdministrativeDeadlines extends ListRecords
{
    protected static string $resource = AdministrativeDeadlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
