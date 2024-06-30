<?php

namespace App\Http\Controllers\Game;

use App\Models\Game;
use App\Models\User;
use App\Models\Reply;
use App\Models\Comment;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\ScraperAnOneService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class DetailPageController extends Controller
{
    protected $scraperService;

    public function __construct(ScraperAnOneService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    public function detail(Request $request, $subdomain, $id)
    {
        $name = $request->subdomain;
        if ($subdomain === 'download') {
            return $this->download($request, $subdomain, $id);
        }
        // return $id;
        return $this->gameDetail($request, $id, $name, null);
    }

    public function user_game_detail(Request $request, $subdomain, $user_name, $id)
    {
        $name = $request->subdomain;
        $user = User::find($request->query('id', null));
        if ($user && $user->user_token == 3) {
            return abort(404);
        }
        return $this->gameDetail($request, $id, $name, $user_name);
    }

    public function gameDetail(Request $request, $id, $name, $user_name)
    {
        $game = Game::where('id', $id)->where('post_status', '=', 'Published')->firstOrFail();
        //need to check ban or not
        $this->validateSlug($game, $name, $user_name);

        $MediaFire = isset($game->download_links['MediaFire']) ? true : null;

        $cm_page = $request->query('cm_page', 1);
        $reply_page = $request->query('rp_page', 1);

        $cm_id_encrypt = $request->query('cm_id', null);
        $rp_id_encrypt = $request->query('rp_id', null);

        $view_cm = null;
        $view_rp = null;
        $cm_id = null;
        $rp_id = null;
        if ($cm_id_encrypt) {
            $cm_id = decrypt($cm_id_encrypt);

            $comment_abc = Comment::where('id', $cm_id)->where('post_id', $id)->get();
            if (!$comment_abc->isEmpty()) {
                $view_rp = ''; // Initialize $view_rp variable
                if ($rp_id_encrypt) {
                    $rp_id = decrypt($rp_id_encrypt);
                    $reply_abc = Reply::where('id', $rp_id)->where('comment_id', $cm_id)->first();
                    if ($reply_abc) {
                        $view_rp = view('results.reply', ['reply' => $reply_abc])->render();
                    }
                }
                $view_cm = view('results.comment', ['comments' => $comment_abc, 'view_rp' => $view_rp, 'rp_id' => $rp_id])->render();
            }
        }

        // if ($rp_id) {
        //     $view_rp = Reply::find($rp_id);
        // }

        if ($request->ajax() && ($reply_page >= 2 || $cm_page >= 2)) {
            return $this->ajaxResponse($request, $id, $cm_page, $reply_page, $cm_id, $rp_id, $view_rp);
        }

        $most_downloaded_games = Game::where('id', '!=', $id)
            ->where('post_status', '=', 'Published')
            ->whereRaw("JSON_EXTRACT(downloads, '$[0]') > ?", [20])
            ->orderByRaw("CAST(JSON_EXTRACT(downloads, '$[0]') AS UNSIGNED) DESC")
            ->inRandomOrder()
            ->paginate(9);

        $today_most_downloaded_games = Game::where('id', '!=', $id)
            ->where('post_status', '=', 'Published')
            ->whereRaw("JSON_EXTRACT(downloads, '$[7]') > ?", [0])
            ->orderByRaw("CAST(JSON_EXTRACT(downloads, '$[7]') AS UNSIGNED) DESC")
            ->latest()
            ->paginate(8);

        $questions = Question::where("title", "detail_page")->first();

        $game_user_id = $game->user->id;
        return view('game.detail', compact('game', 'MediaFire', 'most_downloaded_games', 'today_most_downloaded_games', 'user_name', 'view_cm', 'view_rp', 'cm_id', 'cm_id_encrypt', 'rp_id_encrypt', 'game_user_id', 'questions'));
    }

    private function validateSlug($game, $name, $user_name = null)
    {
        if (Str::slug($game->name) != $name) {
            abort(404);
        }

        if ($game->user->user_token == 3) {
            return 'banned post';
        }

        $expectedSlug = Str::slug($game->name);
        $validSlug = Str::slug($name);
        if ($user_name !== null) {
            $expectedSlug = Str::slug($game->user->name);
            $validSlug = Str::slug($user_name);
        }
        if ($validSlug != $expectedSlug) {
            abort(404);
        }
    }

    private function ajaxResponse(Request $request, $id, $cm_page, $reply_page, $cm_id, $rp_id, $view_rp)
    {
        if ($reply_page >= 2) {
            // $replies = $this->getReplies($request->cm_id, $reply_page);
            $replies = Comment::find($request->comment_id)
                ->replies()
                ->with('from_user')
                ->where('id', '!=', $rp_id)
                ->orderBy('created_at', 'asc')
                ->paginate(3, ['*'], 'page', $reply_page);

            $replies->getCollection()->transform(function ($reply) {
                return [
                    'name' => $reply->name,
                    'from_user_id' => $reply->from_user_id,
                    'to_user_id' => $reply->to_user_id,
                    'text' => $reply->text,
                    'likes' => $reply->likes,
                    'post_id' => $reply->post_id,
                    'reply_to' => $reply->reply_to,
                    'created_at' => $reply->created_at,
                    'comment_id' => $reply->comment_id,

                    'encrypt_comment_id' => encrypt($reply->comment_id),
                    'encrypt_from_user_id' => encrypt($reply->from_user_id),
                    'encrypt_name' => encrypt($reply->name),
                    'from_user' => $reply->from_user,
                ];
            });
            return response()->json($replies, 200);
        }

        if ($cm_page >= 2) {
            $comments = Game::find($id)
                ->comments()
                ->where('id', '!=', $cm_id)
                ->with('replies')
                ->paginate(5, ['*'], 'page', $cm_page);

            return view('results.comment', ['comments' => $comments, 'view_rp' => $view_rp, 'rp_id' => $rp_id])->render();
        }
    }

    // public function getReplies($commentId, $page = 1)
    // {
    //     $replies = Comment::find($commentId)
    //         ->replies()
    //         ->orderBy('created_at', 'asc')
    //         ->paginate(3, ['*'], 'page', $page);

    //     return $replies;
    // }

    public function download($request, $subdomain, $link)
    {
        $cacheKey = 'download_link_' . $link;
        $gameId_key = 'game_id_' . $request->query('id');
        $id = Cache::get($gameId_key);
        $id = Crypt::decrypt($id);
        $game = Game::find($id);
        if (Cache::has($cacheKey)) {
            $encryptedLink = Cache::get($cacheKey);
            $dir_link = Crypt::decrypt($encryptedLink);
            // return $dir_link;
            // Make a HEAD request to check if the link is accessible
            try {
                $response = Http::head($dir_link);

                if ($response->successful()) {
                    // The link is working, proceed with redirection
                    // Log::info('Redirecting to: ' . $dir_link);
                    $dir_links = null;
                    if (strpos($dir_link, 'an1.com') !== false && strpos($dir_link, 'an1.net') === false || strpos($dir_link, 'an1.co') === false) {
                        $dir_links = $this->scraperService->scrapeDetailData($dir_link);
                    }

                    $randomGames = Game::inRandomOrder()->limit(8)->get();
                    return view('game.download', compact('dir_link', 'dir_links', 'game', 'randomGames'));
                    // return redirect()->away($dir_link);
                } else {
                    // The link is not accessible
                    return abort(404, 'The download link is not accessible.');
                }
            } catch (\Exception $e) {
                return abort(500, 'An error occurred: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('games.detail', [
                'subdomain' => Str::slug($game->name),
                'id' => $game->id,
            ]);
        }
    }

    public function short_decrypt($value)
    {
        $decoded = base64_decode(strtr($value, '-_', '+/'));
        return Crypt::decrypt($decoded);
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
