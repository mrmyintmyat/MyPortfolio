<?php

namespace App\Filament\Resources\GameResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;

class UserStatus extends ChartWidget
{
    protected static ?string $heading = 'User Status';

    protected function getData(): array
    {
        // Fetch the data from the database
        $statuses = User::select('status')->groupBy('status')->get();

        // Define custom colors for the pie chart segments
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        // Prepare the data for the chart
        $data = [];
        $i = 0; // Counter for cycling through colors
        foreach ($statuses as $status) {
            $data['labels'][] = $status->status;
            $data['datasets'][0]['data'][] = User::where('status', $status->status)->count();
            // Assign a color to the current dataset
            $data['datasets'][0]['backgroundColor'][] = $colors[$i % count($colors)];
            $i++; // Move to the next color
        }

        return $data;
    }

    protected function getType(): string
    {
        return 'pie';
    }

    public function getColumns(): int|string|array
    {
        return 2;
    }
}
