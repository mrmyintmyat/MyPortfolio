<?php

namespace App\Http\Controllers\Game;

use session;
use App\Models\Game;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GameController extends Controller
{
    public function index(Request $request, $category = null)
    {
        if (!$category) {
            $games = $this->getAllGames();
        } else{
            $games = $this->getCategoryGames($category);
        }

        if ($request->ajax()) {
            $page = $request->input('page');
            $category = $request->input('category');
            $gamesQuery = Game::latest()
                ->where('post_status', '!=', '0');

            if ($category) {
                $gamesQuery->where(function ($query) use ($category) {
                    $query->where('category', 'like', "%$category%")->orWhere('category', 'like', "%$category%");
                });
            }

            // Log the SQL query being executed
            // \Log::info('SQL Query:', ['query' => $gamesQuery->toSql(), 'bindings' => $gamesQuery->getBindings()]);

            $games = $gamesQuery->paginate(10, ['*'], 'page', $page)->shuffle();

            return view('results.search-results-games', ['games' => $games])->render();
        }

        $popular_games = Game::orderBy('downloads', 'desc')
            ->where('post_status', '!=', '0')
            ->where('downloads', '>', 20)->paginate(5);

        return view('game.index', compact('games', 'popular_games'));
    }

    public function getAllGames()
    {
        $games = Game::latest()->where('post_status', '!=', '0')
            ->paginate(10)->shuffle();

        return $games;

    }

    public function getCategoryGames($category)
    {
        $gamesQuery = Game::latest()->where('post_status', '!=', '0');

        if ($category === 'new' || $category === 'New') {
            $gamesQuery->where('category', 'not like', '%old%');
            $games = $gamesQuery->paginate(10);
        } elseif ($category) {
            $gamesQuery->where('category', 'like', "%$category%")->inRandomOrder();
            $games = $gamesQuery->paginate(10)->shuffle();
        }

        return $games;
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

        // $page = $request->input('search_nextPage');
        // if ($page) {
        //     $games = Game::whereRaw('LOWER(REPLACE(name, " ", "")) LIKE ?', ['%' . strtolower(str_replace(' ', '', $query)) . '%'])
        //         ->where('post_status', '!=', '0')
        //         ->latest()
        //         ->paginate(10, ['*'], 'page', $page);
        //     $html = view('results.search-results-games', ['games' => $games])->render();
        //     return response()->json(['html' => $html]);
        // }

        $games = Game::whereRaw('LOWER(REPLACE(name, " ", "")) LIKE ?', ['%' . strtolower(str_replace(' ', '', $query)) . '%'])
            ->where('post_status', '!=', '0')
            ->latest()
            ->paginate(10);
        $startCount = 10;
        $html = view('results.search-results-games', ['games' => $games])->render();
        return response()->json(['html' => $html]);
    }

    public function games_search_scroll(Request $request)
    {
        $query = $request->input('query');

        $page = $request->input('search_nextPage');
        if ($page) {
            $games = Game::whereRaw('LOWER(REPLACE(name, " ", "")) LIKE ?', ['%' . strtolower(str_replace(' ', '', $query)) . '%'])
                ->where('post_status', '!=', '0')
                ->latest()
                ->paginate(10, ['*'], 'page', $page);
            $html = view('results.search-results-games', ['games' => $games])->render();
            return response()->json(['html' => $html]);
        }

        return redirect()->back();
    }
}
