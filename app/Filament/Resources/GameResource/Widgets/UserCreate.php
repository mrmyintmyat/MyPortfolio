<?php

namespace App\Filament\Resources\GameResource\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class UserCreate extends ChartWidget
{
    protected static ?string $heading = 'User Create';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count();

            return [
                'datasets' => [
                    [
                        'label' => 'User Create',
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    ],
                ],
                'labels' => $data->map(fn (TrendValue $value) => $value->date),
            ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
