<?php

namespace App\Http\Controllers\Game;

use App\Models\Game;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IncrementGameController extends Controller
{
    public function store(Request $request)
    {
        $gameId = $request->id;
        // $link = $request->link;
        // $download_again = $request->again;
        $isMediaFire = $request->isMediaFire;
        $key = 'downloaded_game_' . $gameId;
        $game = Game::findOrFail($gameId);
        // Check if the game has already been downloaded in this session
        // if (!$request->session()->has($key)) {
        DB::statement(
            "
            UPDATE games
            SET downloads = JSON_SET(downloads, '$[0]', JSON_EXTRACT(downloads, '$[0]') + 1),
                downloads = JSON_SET(downloads, '$[7]', JSON_EXTRACT(downloads, '$[7]') + 1)
            WHERE id = ? AND post_status != '0'
        ",
            [$gameId],
        );

        if (Auth::check()) {
            $download = Download::where('user_id', Auth::user()->id)
                ->where('game_id', $game->id)
                ->first();

            // If the user has not downloaded the game, create a new download record
            if ($download) {
                $download->count += 1;
                $download->save();
            } else {
                Download::create([
                    'game_name' => $game->name,
                    'game_id' => $game->id,
                    'count' => 1,
                    'user_id' => Auth::user()->id,
                ]);
            }
        }
        // Mark the game as downloaded in the session
        // $request->session()->put($key, true);

        // if ($isMediaFire == true) {
        //     $direct_link = $this->scrap_mediafire($link);
        //     return response()->json(['success' => true, 'direct_link' => $direct_link]);
        // }

        return response()->json(['success' => true]);
        // }

        // return response()->json(['success' => false, 'message' => 'Game already downloaded']);
    }

    public function scrap_mediafire($link)
    {
        try {
            $htmlContent = file_get_contents($link);
        } catch (\Throwable $th) {
            return 'Error fetching HTML content.';
        }

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
