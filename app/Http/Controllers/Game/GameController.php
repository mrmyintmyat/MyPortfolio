<?php

namespace App\Http\Controllers\Game;

use session;
use App\Models\Game;
use App\Models\Noti;
use App\Models\User;
use App\Models\Reply;
use GuzzleHttp\Client;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\WebCmNotificationController;
use Illuminate\Support\Facades\Session as UserSession;

class GameController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('password.confirm');
    // }

    public function index(Request $request)
    {
        $category = $request->query('category', null);
        $games = $category ? $this->getCategoryGames($category) : $this->getAllGames();

        if ($request->ajax()) {
            return $this->ajaxResponse($request, $games, null);
        }

        $popular_games = Game::where('post_status', '=', 'Published')
            ->whereRaw("JSON_EXTRACT(downloads, '$[0]') > ?", [20])
            ->orderByRaw("CAST(JSON_EXTRACT(downloads, '$[0]') AS UNSIGNED) DESC")
            ->paginate(5);

        $user_name = null;
        return view('game.index', compact('games', 'popular_games', 'user_name'));
    }

    public function profile(Request $request, $name)
    {
        $category = $request->query('category', null);
        $id = $request->query('id', null);
        if ($id) {
            $user = User::findOrFail($id);
            $this->validateUser($user, $name);

            $games = $category ? $this->getCategoryGames($category, $id) : $this->getUserGames($user, $id);

            if ($request->ajax()) {
                return $this->ajaxResponse($request, $games, $name);
            }

            $popular_games = $this->getPopularGames($user, $id);
            $user_name = $name;

            return view('game.index', compact('games', 'popular_games', 'user_name'));
        }elseif($name === 'privacy-policy'){
          return $this->privacy_policy();
        }
         elseif (!Auth::check()) {
            return redirect('/login');
        } elseif ($name === 'notices') {
            $user = Auth::user();
            $notices = $user->notices()->latest()->paginate(12);
            foreach ($user->notices()->where('is_checked', '=', '0')->get() as $notice) {
                $notice->is_checked = 1;
                $notice->save();
            }
            return view('game.notices', compact('notices'));
        } elseif ($name === 'profile') {
            $user = Auth::user();
            return view('game.profile', compact('user'));
        } else {
            abort(404);
        }
    }

    private function validateUser($user, $name)
    {
        if ($user->user_token == 3) {
            return 'banned';
        }
        if (Str::slug($user->name) != $name || ($user->status !== 'admin' && $user->status !== 'adminzynn')) {
            abort(404);
        }
    }

    private function ajaxResponse(Request $request, $games, $user_name)
    {
        $page = $request->input('page');
        $category = $request->input('category');
        $user_id = $request->input('user_id');

        $gamesQuery = Game::latest()->where('post_status', '=', 'Published');

        if ($category) {
            if ($category === 'new' || $category === 'New') {
                $gamesQuery->where('category', 'not like', '%old%');
            } elseif ($category) {
                $gamesQuery->where('category', 'like', "%$category%")->inRandomOrder();
            }
        } elseif ($user_id) {
            $gamesQuery->where('user_id', '=', $user_id);
        }

        $games = $gamesQuery->paginate(10, ['*'], 'page', $page)->shuffle();

        return view('results.search-results-games', ['games' => $games, 'user_name' => $user_name])->render();
    }

    private function getUserGames($user, $id)
    {
        return $user->games()->where('user_id', '=', $id)->latest()->where('post_status', '=', 'Published')->paginate(10)->shuffle();
    }

    private function getPopularGames($user, $id)
    {
        return $user
            ->games()
            ->where('user_id', '=', $id)
            ->latest()
            ->where('post_status', '=', 'Published')
            ->whereRaw("JSON_EXTRACT(downloads, '$[0]') > ?", [20])
            ->orderByRaw("CAST(JSON_EXTRACT(downloads, '$[0]') AS UNSIGNED) DESC")
            ->paginate(5);
    }

    public function getAllGames()
    {
        $games = Game::latest()->where('post_status', '=', 'Published')->paginate(10)->shuffle();

        return $games;
    }

    public function getCategoryGames($category)
    {
        $gamesQuery = Game::latest()->where('post_status', '=', 'Published');

        if ($category === 'new' || $category === 'New') {
            $gamesQuery->where('category', 'not like', '%old%');
            $games = $gamesQuery->paginate(10);
        } elseif ($category) {
            $gamesQuery->where('category', 'like', "%$category%")->inRandomOrder();
            $games = $gamesQuery->paginate(10)->shuffle();
        }

        return $games;
    }

    public function post_comment(Request $request, $user_name, $id, $name)
    {
        $id = decrypt($id);
        $game = Game::where('id', $id)->where('post_status', '=', 'Published')->firstOrFail();

        if (Str::slug($game->name) != $name) {
            abort(404);
        }

        if (Auth::check()) {
            $from_user = Auth::user()->id;
            $name = Auth::user()->name;
        } else {
            $user_latest_id = User::latest()->value('id') + 1;
            $randomname = $this->generateRandomPassword(8);
            $email = Str::slug($request->name) . '@zynn.games';
            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'status' => 'guest',
                'is_logged_in' => true,
                'setting' => ['notification' => true],
                'password' => bcrypt($user_latest_id * 937667564564 - 539523223322),
            ]);
            Auth::login($user);
            $from_user = $user->id;
            $name = $user->name;
        }

        if ($request->has('to_user')) {
            $to_user_id = decrypt($request->to_user);
        } else {
            $to_user_id = $game->user_id;
        }

        $request->validate([
            'text' => 'required|string',
            'reply_to' => 'nullable',
            'post_id' => 'required',
            'parent_id' => 'nullable',
        ]);

        $notices_link = env('APP_URL') . '/notices';

        $user_unchecked_notices = User::find($to_user_id)->notices()
        ->where('is_checked', 0)
        ->where('type', 'LIKE', '%"link"%')
        ->get();

        if ($request->has('parent_id')) {
            $comment = Reply::create([
                'name' => $name,
                'from_user_id' => $from_user,
                'to_user_id' => $to_user_id,
                'text' => $request->text,
                'post_id' => $id,
                'reply_to' => decrypt($request->reply_to),
                'comment_id' => decrypt($request->parent_id),
            ]);

            $user = User::find($comment->to_user_id);
            if ($user && $to_user_id != $from_user && $comment) {
                $fromUserName = $comment->from_user->name ?? 'Unknown User';
                $notificationMessage = "<h6 class='m-0 d-inline'>$fromUserName</h6>&nbsp;replied to you.";
                $from_user_logo = $comment->from_user->logo;

                $webnotificationMessage = "$fromUserName replied to you.";
                $noti = $this->create_noti("$from_user_logo", $notificationMessage, $request->text, $to_user_id, $id, $comment->comment_id, $comment->id, Str::slug($game->name), $from_user);

                if ($noti && $comment->to_user->setting && $comment->to_user->is_logged_in && $comment->to_user->setting['notification'] && count($user_unchecked_notices) < 3) {
                    if ($user->device_token != null) {
                        $webNotificationController = new WebCmNotificationController();
                        $webNotificationController->sendWebNotification([$user->device_token], "$game->name Post.", "$webnotificationMessage", $notices_link);
                    }
                }
            }

            $transformedComment = [
                'name' => $comment->name,
                'from_user_id' => $comment->from_user_id,
                'to_user_id' => $comment->to_user_id,
                'text' => $comment->text,
                'likes' => $comment->likes,
                'post_id' => $comment->post_id,
                'reply_to' => $comment->reply_to,
                'created_at' => $comment->created_at,
                'comment_id' => $comment->comment_id,
                'encrypt_comment_id' => encrypt($comment->comment_id),
                'encrypt_from_user_id' => encrypt($comment->from_user_id),
                'encrypt_name' => encrypt($comment->name),
                'from_user' => $comment->from_user,
            ];

            return response()->json($transformedComment, 200);
        } else {
            $comment = Comment::create([
                'name' => $name,
                'from_user_id' => $from_user,
                'to_user_id' => $to_user_id,
                'text' => $request->text,
                'post_id' => $id,
            ]);

            $user = User::find($comment->to_user_id);

            if ($to_user_id != $from_user && $comment && $user) {
                $fromUserName = $comment->from_user->name;

                // Create the notification message
                $notificationMessage = "<h6 class='m-0 d-inline'>$fromUserName</h6>&nbsp;commented on your $game->name post.";
                $webnotificationMessage = "$fromUserName commented on your $game->name post.";
                $noti = $this->create_noti("$game->logo", $notificationMessage, $request->text, $to_user_id, $id, $comment->id, null, Str::slug($game->name), $from_user);

                if ($noti && $comment->to_user->setting && $comment->to_user->is_logged_in && $comment->to_user->setting['notification'] && count($user_unchecked_notices) < 3) {
                    if ($user->device_token != null) {
                        $webNotificationController = new WebCmNotificationController();
                        $webNotificationController->sendWebNotification([$user->device_token], "$game->name Post.", "$webnotificationMessage", $notices_link);
                    }
                }
            }

            return view('results.comment', ['comment' => $comment])->render();
        }
    }

    public function create_noti($image, $title, $text, $user_id, $game_id, $comment_id, $reply_id, $game_name, $from_user)
    {
        $cm_id = encrypt($comment_id);
        $rp_id = encrypt($reply_id);
        $type = [];

        if ($reply_id) {
            $type['link'] = "/$game_id/$game_name?cm_id=$cm_id&rp_id=$rp_id#scroll_$comment_id" . '3';
        } elseif ($comment_id) {
            $type['link'] = "/$game_id/$game_name?cm_id=$cm_id#scroll_$comment_id" . '3';
        }

        return Noti::create([
            'image' => $image,
            'title' => $title,
            'text' => $text,
            'user_id' => $user_id,
            'game_id' => $game_id,
            'from_id' => $from_user,
            'type' => $type,
        ]);
    }

    public function games_search(Request $request)
    {
        $query = $request->input('query');

        // $page = $request->input('search_nextPage');
        // if ($page) {
        //     $games = Game::whereRaw('LOWER(REPLACE(name, " ", "")) LIKE ?', ['%' . strtolower(str_replace(' ', '', $query)) . '%'])
        //         ->where('post_status', '=', 'Published')
        //         ->latest()
        //         ->paginate(10, ['*'], 'page', $page);
        //     $html = view('results.search-results-games', ['games' => $games])->render();
        //     return response()->json(['html' => $html]);
        // }

        $games = Game::whereRaw('LOWER(REPLACE(name, " ", "")) LIKE ?', ['%' . strtolower(str_replace(' ', '', $query)) . '%'])
            ->where('post_status', '=', 'Published')
            ->latest()
            ->paginate(10);
        $startCount = 10;
        $html = view('results.search-results-games', ['games' => $games])->render();
        return response()->json(['html' => $html]);
    }

    public function games_search_scroll(Request $request)
    {
        $query = $request->input('query');
        $user_id = $request->input('user_id');
        $page = $request->input('search_nextPage');

        if ($page) {
            $games = Game::whereRaw('LOWER(REPLACE(name, " ", "")) LIKE ?', ['%' . strtolower(str_replace(' ', '', $query)) . '%'])
                ->where('post_status', '=', 'Published')
                ->latest()
                ->paginate(10, ['*'], 'page', $page);
            $html = view('results.search-results-games', ['games' => $games])->render();
            return response()->json(['html' => $html]);
        } elseif ($user_id) {
            $games = Game::whereRaw('LOWER(REPLACE(name, " ", "")) LIKE ?', ['%' . strtolower(str_replace(' ', '', $query)) . '%'])
                ->where('post_status', '=', 'Published')
                ->where('user_id', '=', $user_id)
                ->latest()
                ->paginate(10, ['*'], 'page', $page);
            $html = view('results.search-results-games', ['games' => $games])->render();
            return response()->json(['html' => $html]);
        }

        return redirect()->back();
    }

    public function privacy_policy(){
        return view('game.privacy');
    }

    function generateRandomPassword($length = 12) {
        // Define character sets for different types of characters
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';
        $specialChars = '%$#@^&*!(@)#_=-';

        // Generate a random password by combining characters from different sets
        $charset = $lowercase . $uppercase . $numbers . $specialChars;
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $charset[rand(0, strlen($charset) - 1)];
        }

        // Shuffle the password to make it more random
        $password = str_shuffle($password);

        return $password;
    }
}
