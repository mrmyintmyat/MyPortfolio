<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Game\DetailPageController;

class GameController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        $totalGamesCount = $user->games()->count();
        $publishedCount = $user->games()->where('post_status', 'Published')->count();
        $privateCount = $user->games()->where('post_status', 'Private')->count();
        $reviewingCount = $user->games()->where('post_status', 'Reviewing')->count();

        $counts = [
            'TOTAL GAMES' => $totalGamesCount,
            'PUBLISHED' => $publishedCount,
            'PRIVATE' => $privateCount,
            'REVIEWING' => $reviewingCount,
        ];

        $games = $user->games()->get();
        $totalDownloads = [];

        foreach ($games as $game) {
            $downloads = $game->downloads ?? [0, 0, 0, 0, 0, 0, 0, 0];

            foreach ($downloads as $key => $value) {
                // Skip adding if it's the first array element
                if ($key === 0) {
                    continue;
                }

                $totalDownloads[$key] = ($totalDownloads[$key] ?? 0) + $value;
            }
        }

        $totalDownloads = json_encode($totalDownloads);

        return view('admin.games.index', compact('counts', 'totalDownloads'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        if (isset($search)) {
            $public_games = $user
                ->games()
                ->where(function ($query) use ($search) {
                    $query->where('post_status', 'Published')->where('name', 'like', "%$search%");
                })
                ->orWhere(function ($query) use ($search) {
                    $query->where('post_status', 'Published')->where('name', 'like', "%$search%");
                })
                ->latest()
                ->paginate(18);

            $private_games = $user
                ->games()
                ->where(function ($query) use ($search) {
                    $query
                        ->where('post_status', 'Private')
                        ->Orwhere('post_status', 'Reviewing')
                        ->where('name', 'like', "%$search%");
                })
                ->latest()
                ->paginate(18);

            return view('admin.games.games', compact('public_games', 'private_games'));
        } else {
            // If search term is not set, retrieve all games
            $public_games = $user->games()->where('post_status', '=', 'Published')->latest()->paginate(18);

            $private_games = $user
                ->games()
                ->whereIn('post_status', ['Private', 'Reviewing'])
                ->latest()
                ->paginate(18);

            return view('admin.games.games', compact('public_games', 'private_games'));
        }
    }

    public function view_game(Request $request, $id)
    {
        $game = Game::where('id', $id)
            ->where('user_id', '=', Auth::user()->id)
            ->firstOrFail();
        $detailPageController = new DetailPageController();
        return $detailPageController->gameDetail($request, $game->id, Str::slug($game->name), null);

        // $cm_page = $request->query('cm_page', 1);
        // $reply_page = $request->query('rp_page', 1);

        // if ($request->ajax() && $reply_page >= 2) {
        //     $replies = $this->getReplies($request->cm_id, $reply_page);
        //     return response()->json($replies, 200);
        // }

        // $comments = Comment::
        //     with('replies')
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(3, ['*'], 'page', $cm_page);

        // if ($request->ajax() && $cm_page >= 2) {
        //     return response()->json($comments, 200);
        // }

        // $most_downloaded_games = Game::where('id', '!=', $id)
        //     ->where('post_status', '=', 'Published')
        //     ->where('downloads', '>', 20)
        //     ->inRandomOrder()
        //     ->paginate(5);
        // return view('game.detail', compact('game', 'most_downloaded_games', 'comments'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.games.post_game', compact('categories'));
    }

    public function store(Request $request)
    {
        $selectedCategories = $request->category;
        $category = implode(', ', $selectedCategories);

        $downloadLinks = $request->input('download_links', []);

        $downloads_link = [];

        foreach ($downloadLinks as $link) {
            $name = $link["'name'"] ?? '';
            $url = $link["'link'"] ?? '';

            if ($name !== '' && $url !== '') {
                $downloads_link[$name] = $url;
            }
        }

        $settings = $request->input('setting', []);

        $setting = [];

        foreach ($settings as $link) {
            $name = $link["'name'"] ?? '';
            $value = $link["'value'"] ?? '';
            $value = $value === 'on' ? true : false;

            $setting[$name] = $value;
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'size' => 'required|string',
            'online_or_offline' => 'required|in:online,offline,Online/Offline',
            'logo' => 'required',
            'category' => 'required',
            'download_links' => 'required',
            'setting' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $images = [];
        try {
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    // Store each image
                    $path = $file->store('games_images', 'public');
                    $images[] = $path;
                }
            } else {
                $images = json_decode($request->image, true);
            }
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('game_logos', 'public');
                $logo = $path;
            }
        } catch (\Exception $e) {
            // Handle the error, e.g., log it, return a response, etc.
            return response()->json(['error' => 'Error storing images.'], 500);
        }

        if (Auth::user()->user_token == 2) {
            $post_status = 'Published';
        } else {
            $post_status = 'Reviewing';
        }

        try {
            $game = Game::create([
                'name' => $request->name,
                'about' => $request->about,
                'size' => $request->size,
                'post_status' => $post_status,
                'online_or_offline' => $request->online_or_offline,
                'logo' => $logo,
                'category' => $category,
                'downloads' => [0, 0, 0, 0, 0, 0, 0, 0],
                'download_links' => $downloads_link,
                'setting' => $setting,
                'image' => $images,
                'user_id' => Auth::user()->id,
            ]);
            return redirect()->back()->with('success', 'Game created successfully.')->withInput();
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }

    public function edit($id)
    {
        $user = Auth::user();

        $categories = Category::all();
        $game = $user->games()->findOrFail($id);
        return view('admin.games.edit', compact('game', 'categories'));
    }

    public function update(Request $request, $id)
    {
        Log::info($request->all());
        $user = Auth::user();

        $game = $user->games()->findOrFail($id);
        $downloadLinks = $request->input('download_links', []);

        $selectedCategories = $request->category;

        // Convert string to array if it's not already an array
        if (!is_array($selectedCategories)) {
            $selectedCategories = explode(', ', $selectedCategories);
        }

        $category = implode(', ', $selectedCategories);


        $downloads_link = [];

        foreach ($downloadLinks as $link) {
            $name = $link["'name'"] ?? '';
            $url = $link["'link'"] ?? '';

            if ($name !== '' && $url !== '') {
                $downloads_link[$name] = $url;
            }
        }

        $settings = $request->input('setting', []);

        $setting = [];

        foreach ($settings as $link) {
            $name = $link["'name'"] ?? '';
            $value = $link["'value'"] ?? '';
            $value = $value === 'on' ? true : false;

            $setting[$name] = $value;
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'size' => 'required|string',
            'online_or_offline' => 'required|in:online,offline,Online/Offline',
            'category' => 'required',
            'downloads' => 'required',
            'download_links' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $oldImages = $game->image;
        $oldlogo = $game->logo;
        $ImageFromRequest = json_decode($request->Existimage, true);
        $logo = $game->logo;
        try {
            if ($request->hasFile('newImage')) {
                foreach ($request->file('newImage') as $file) {
                    // Store each new image
                    $path = $file->store('games_images', 'public');
                    $newImages[] = $path;
                }
            }

            foreach ($oldImages as $oldImage) {
                if (!in_array($oldImage, $ImageFromRequest)) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $oldImage));
                } else {
                    $newImages[] = $oldImage;
                }
            }

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('game_logos', 'public');
                $logo = $path;
                Storage::disk('public')->delete(str_replace('/storage/', '', $oldlogo));
            }
        } catch (\Exception $e) {
            // Handle the error, e.g., log it, return a response, etc.
            return response()->json(['error' => 'Error storing images.'], 500);
        }

        try {
            $game->update([
                'name' => $request->name,
                'about' => $request->about,
                'size' => $request->size,
                'post_status' => $request->post_status,
                'online_or_offline' => $request->online_or_offline,
                'logo' => $logo,
                'category' => $category,
                'download_links' => $downloads_link,
                'image' => $newImages,
                'setting' => $setting,
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('success', 'Game updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $game = $user->games()->findOrFail($id);
        $game->comments()->delete();
        $game->replies()->delete();

        foreach ($game->image as $image) {
            $fileExists = Storage::disk('public')->exists(str_replace('/storage/', '', $image));

            if ($fileExists) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $image));
            }
        }

        Storage::disk('public')->delete(str_replace('/storage/', '', $game->logo));
        // Delete the game
        $game->delete();

        return response()->json(['success' => 'Game deleted successfully']);
    }
}
