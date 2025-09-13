<?php

namespace App\Filament\Resources\Beasiswas\Pages;

use App\Filament\Resources\Beasiswas\BeasiswaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBeasiswa extends ViewRecord
{
    protected static string $resource = BeasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
