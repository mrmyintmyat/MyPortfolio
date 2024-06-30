<?php

namespace App\Filament\Resources\GameRequestResource\Pages;

use App\Filament\Resources\GameRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListGameRequests extends ListRecords
{
    protected static string $resource = GameRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Pending' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'Pending')),
            'Complete' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'Complete')),
        ];
    }
}
