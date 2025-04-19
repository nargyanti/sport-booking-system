<?php

namespace App\Filament\Resources\SubsidyResource\Pages;

use App\Filament\Resources\SubsidyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubsidies extends ListRecords
{
    protected static string $resource = SubsidyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
