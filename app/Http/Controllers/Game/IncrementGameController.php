<?php

namespace App\Http\Controllers\Game;

use App\Models\Game;
use App\Models\Download;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class IncrementGameController extends Controller
{
    public function store(Request $request)
    {
        // $gameId = $request->id;
        // // $link = $request->link;
        // // $download_again = $request->again;
        $isMediaFire = filter_var($request->isMediaFire, FILTER_VALIDATE_BOOLEAN);
        // // $key = 'downloaded_game_' . $gameId;
        // $game = Game::findOrFail($gameId);
        // // Check if the game has already been downloaded in this session
        // // if (!$request->session()->has($key)) {
        // DB::statement(
        //     "
        //     UPDATE games
        //     SET downloads = JSON_SET(downloads, '$[0]', JSON_EXTRACT(downloads, '$[0]') + 1),
        //         downloads = JSON_SET(downloads, '$[7]', JSON_EXTRACT(downloads, '$[7]') + 1)
        //     WHERE id = ? AND post_status != '0'
        // ",
        //     [$gameId],
        // );

        $gameId = $request->id;
        $game = Game::findOrFail($gameId);

        // Construct the JSON object for the update
        $newDownloads = $game->downloads;
        $newDownloads[0] += 1; // Increment the first value in the JSON array
        $newDownloads[7] += 1; // Increment the eighth value in the JSON array

        // Update the game record with the new downloads
        $game->downloads = $newDownloads;
        $game->save();

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
        // Ensure $request->linkName is a string
        $linkName = (string) $request->linkName;

        // Log and check if link name exists in download_links
        if (isset($game->download_links[$linkName])) {
            if ($isMediaFire) {
                $link = $game->download_links[$linkName];
                $scrappedLink = $this->scrap_mediafire($link);
            } else {
                $scrappedLink = $game->download_links[$linkName];
            }

            $encryptedLink = Crypt::encryptString($scrappedLink);
            $uniqueId = Str::uuid()->toString();

            // Cache::put($cacheKey, $scrappedLink, now()->addMinutes(10));
            Cache::put('download_link_' . $uniqueId, $encryptedLink, now()->addMinutes(10));
            $base_url = route('games.detail', ['subdomain' => 'download', 'id' => $uniqueId]);

            $download_page_link = $base_url . "?id=$game->id";

            $direct_link = $this->makeadslink($game, $download_page_link);

            if (empty($direct_link)) {
                Log::error('Direct Link is empty or null.');
            } else {
            }
        } else {
            Log::warning('Link Name not found in download links:', [$linkName]);
        }

        return response()->json(['success' => true, 'direct_link' => $direct_link]);

        // }

        // return response()->json(['success' => false, 'message' => 'Game already downloaded']);
    }

    public function makeadslink($game, $link)
    {
        if (isset($game->setting['earthnewss24_ads']) && $game->setting['earthnewss24_ads'] && $game->user->w2ad_token != null) {
            $response = Http::get("https://w2ad.link/api?api={$game->user->w2ad_token}&url=$link");

            if ($response->successful()) {
                $data = $response->json();
                return $data['shortenedUrl'];
            } else {
                $statusCode = $response->status();
                return "Error fetching data. Status code: $statusCode";
            }
        } else {
            return $link;
        }
    }

    public function scrap_mediafire($link)
    {
        try {
            $htmlContent = file_get_contents($link);
        } catch (\Throwable $th) {
            return '/error';
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
                return '/error';
            }
        } else {
            return '/error';
        }
    }
}
