<?php

namespace App\Http\Controllers\Game;

use App\Models\Game;
use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class IncrementGameController extends Controller
{
    public function store(Request $request)
    {
        $gameId = $request->id;
        $link = $request->link;
        // $download_again = $request->again;
        $isMediaFire = $request->isMediaFire;
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

        if ($isMediaFire == true) {
            $direct_link = $this->scrap_mediafire($link);
            Log::info("OK");
            return response()->json(['success' => true, 'direct_link' => $direct_link]);
        }

        return response()->json(['success' => true]);
        // }

        // return response()->json(['success' => false, 'message' => 'Game already downloaded']);
    }

    public function scrap_mediafire($link)
    {
        $htmlContent = file_get_contents($link);

        if ($htmlContent !== false) {
            // Define a regular expression pattern to match a link with class "popsok"
            $pattern = '/<a[^>]+class="input popsok"[^>]*href="([^"]+)"/i';

            // Perform the preg_match
            if (preg_match($pattern, $htmlContent, $matches)) {
                // The extracted link is in $matches[1]
                $extractedLink = $matches[1];
                return $extractedLink;
            } else {
                return 'Link not found.';
            }
        } else {
            return 'Error fetching HTML content.';
        }
    }
}
