<?php

namespace App\Filament\Resources\NotiResource\Pages;

use App\Filament\Resources\NotiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNotis extends ListRecords
{
    protected static string $resource = NotiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
