<?php

namespace App\Filament\Resources\GameResource\Widgets;

use App\Models\Game;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class GamesPerMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Games Create';

    protected function getData(): array
    {
        $data = Trend::model(Game::class)
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

            return [
                'datasets' => [
                    [
                        'label' => 'Game posts',
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    ],
                ],
                'labels' => $data->map(fn (TrendValue $value) => $value->date),
            ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
