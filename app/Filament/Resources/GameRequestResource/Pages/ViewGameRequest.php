<?php

namespace App\Filament\Resources\GameRequestResource\Pages;

use App\Filament\Resources\GameRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGameRequest extends ViewRecord
{
    protected static string $resource = GameRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
