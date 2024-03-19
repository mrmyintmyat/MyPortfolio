<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class GameOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Games', Game::count()),
            Stat::make('Reviewing Games', Game::where('post_status', '=', 'Reviewing')->get()->count()),
            Stat::make('Published Games', Game::where('post_status', '=', 'Published')->get()->count()),
            Stat::make('Private Games', Game::where('post_status', '=', 'Private')->get()->count()),
        ];
    }
}
