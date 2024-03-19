<?php

namespace App\Filament\Resources\NotiResource\Pages;

use App\Filament\Resources\NotiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNoti extends ViewRecord
{
    protected static string $resource = NotiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
