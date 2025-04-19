<?php

namespace App\Filament\Resources\SubsidyResource\Pages;

use App\Filament\Resources\SubsidyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubsidy extends EditRecord
{
    protected static string $resource = SubsidyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
