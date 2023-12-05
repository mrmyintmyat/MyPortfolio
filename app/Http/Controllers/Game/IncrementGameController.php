<?php

namespace App\Http\Controllers\Game;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IncrementGameController extends Controller
{
    public function store(Request $request)
    {
        $gameId = $request->id;
        $download_again = $request->again;
        $key = 'downloaded_game_' . $gameId;

        // Check if the game has already been downloaded in this session
        // if (!$request->session()->has($key)) {
            $game = Game::where('id', $gameId)
                ->where('post_status', '!=', '0')
                ->firstOrFail();

            // Disable timestamps to prevent updated_at from changing
            $game->timestamps = false;

            // Increment downloads
            $game->increment('downloads', 1);

            // Save the game
            $game->save();

            // Mark the game as downloaded in the session
            // $request->session()->put($key, true);

            return response()->json(['success' => true]);
        // }

        // return response()->json(['success' => false, 'message' => 'Game already downloaded']);
    }
}
