<?php

namespace App\Filament\Resources\GameResource\Widgets;

use App\Models\Game;
use Flowframe\Trend\Trend;
use Filament\Widgets\ChartWidget;

class DownloadPerDayChart extends ChartWidget
{
    protected static ?string $heading = 'Downloads';

    protected function getData(): array
    {
        // Fetch trend data for all games
        $games = Game::all();

        // Calculate total downloads for each day
        foreach ($games as $game) {
            $downloads = $game->downloads ?? [0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($downloads as $key => $value) {
                // Skip adding if it's the first array element
                if ($key === 0) {
                    continue;
                }

                $totalDownloads[$key] = ($totalDownloads[$key] ?? 0) + $value;
            }
        }
        // Calculate total downloads for all games
        $totalDownloadsAllGames = array_sum($totalDownloads);

        // Construct the chart data
        return [
            'datasets' => [
                [
                    'label' => 'Downloads (Total)',
                    'data' => $totalDownloads,
                ],
            ],
            'labels' => $games->first()->date, // Assuming all trend data have the same dates
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
