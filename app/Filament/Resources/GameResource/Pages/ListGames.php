<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Models\Game;
use Filament\Actions;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use App\Filament\Resources\GameResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;
use App\Filament\Resources\GameResource\Widgets\GameOverview;
use App\Filament\Resources\GameResource\Widgets\StatsGameOverview;

class ListGames extends ListRecords
{
    // protected static string $view = 'admin.games.index';

    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public static function query(): Builder
    {
        return Game::query()->latest(); // Orders the results by the latest creation timestamp
    }

    public function getTabs(): array
    {
        return [
            'Reviewing' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('post_status', '=', 'Reviewing')),
            'Published' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('post_status', '=', 'Published')),
            'Ban' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('post_status', '=', 'Ban')),
            'Private' => Tab::make()
            ->modifyQueryUsing(fn (Builder $query) => $query->where('post_status', '=', 'Private')),
        ];
    }

}
