<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;

class UpdateDownloadsCommand extends Command
{
    protected $signature = 'update:downloads';

    protected $description = 'Update the downloads column to store JSON data';

    public function handle()
    {
        $games = Game::all();

        foreach ($games as $game) {
            // $game->downloads = [$game->downloads, 0, 0, 0, 0, 0, 0, 0];
            $downloads = $game->downloads;
            $downloads = [2920, 1000, 22, 200, 11, 344, 566, 777];
            $downloads[1] = $downloads[2];
            $downloads[2] = $downloads[3];
            $downloads[3] = $downloads[4];
            $downloads[4] = $downloads[5];
            $downloads[5] = $downloads[6];
            $downloads[6] = $downloads[7];
            $downloads[7] = 0;
            $game->downloads = $downloads;

            $game->save();
        }

        $this->info('Downloads column updated successfully.');
    }
}
