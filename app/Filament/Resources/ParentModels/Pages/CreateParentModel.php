<?php

namespace App\Filament\Resources\ParentModels\Pages;

use App\Filament\Resources\ParentModels\ParentModelResource;
use Filament\Resources\Pages\CreateRecord;

class CreateParentModel extends CreateRecord
{
    protected static string $resource = ParentModelResource::class;
}
