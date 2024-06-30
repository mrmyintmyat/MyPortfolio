<?php

namespace App\Filament\Resources\GameRequestResource\Pages;

use App\Filament\Resources\GameRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGameRequest extends EditRecord
{
    protected static string $resource = GameRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
