<?php

namespace App\Filament\Resources\NotiResource\Pages;

use App\Filament\Resources\NotiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNoti extends EditRecord
{
    protected static string $resource = NotiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
