<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'User' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'user')),
            'Guest' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'guest')),
            'Ban user' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_token', '=', '3')),
            'Request User' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'request')),
            'Admin' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'admin')),
            'Zynn' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', '=', 'adminzynn')),
        ];
    }
}
