<?php

namespace App\Http\Controllers\Game;

use App\Models\Game;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $games = Game::latest()
            ->where('post_status', '!=', '0')
            ->paginate(10);

        if ($request->ajax()) {
            $page = $request->input('page');
            $games = Game::latest()
                ->where('post_status', '!=', '0')
                ->paginate(10, ['*'], 'page', $page);

            return view('results.search-results-games', ['games' => $games])->render();
        }

        // $request->session()->put('sender_id', 'yo');
        return view('game.index', compact('games'));
    }

    public function detail($id, $name)
    {
        $game = Game::where('id', $id)
            ->where('post_status', '!=', '0')
            ->firstOrFail();
        $games = Game::orderBy('downloads', 'desc')
            ->where('id', '!=', $id)
            ->where('post_status', '!=', '0')
            ->where('downloads', '>', 20)
            ->paginate(5);
        $noGames = $games->isEmpty();
        return view('game.detail', compact('game', 'games', 'noGames'));
    }

    public function games_search(Request $request)
    {
        $query = $request->input('query');

        $page = $request->input('search_nextPage');
        if ($page) {
            $games = Game::where('name', 'LIKE', '%' . $query . '%')
                ->where('post_status', '!=', '0')
                ->latest()
                ->paginate(10, ['*'], 'page', $page);
            $html = view('results.search-results-games', ['games' => $games])->render();
            return response()->json(['html' => $html]);
        }

        $games = Game::where('name', 'LIKE', '%' . $query . '%')
            ->where('post_status', '!=', '0')
            ->latest()
            ->paginate(10);

        $html = view('results.search-results-games', ['games' => $games])->render();
        return response()->json(['html' => $html]);
    }

    public function games_search_scroll(Request $request)
    {
        $query = $request->input('query');

        $page = $request->input('search_nextPage');
        if ($page) {
            $games = Game::where('name', 'LIKE', '%' . $query . '%')
                ->where('post_status', '!=', '0')
                ->latest()
                ->paginate(10, ['*'], 'page', $page);
            $html = view('results.search-results-games', ['games' => $games])->render();
            return response()->json(['html' => $html]);
        }

        return redirect()->back();
    }

    public function increment_downloads(Request $request)
    {
        $game = Game::where('id', $request->id)
            ->where('post_status', '!=', '0')
            ->firstOrFail();

        $game->timestamps = false;

        $game->increment('downloads', 1);

        $game->save();

        return response()->json(['success' => true]);
    }
}
