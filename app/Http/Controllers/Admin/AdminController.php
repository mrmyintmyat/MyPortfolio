<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home');
    }

    public function create()
    {
        return view('admin.create_product');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'about' => 'required|string',
            'price' => 'required|string',
            'image_files' => 'required|array',
            'reduced_price' => 'nullable|string',
            'category' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $images = [];

        foreach ($request->file('image_files') as $file) {
            try {
                $path = $file->store('item_images', 'public');
            } catch (\Exception $e) {
                return $e;
            }
            $images[] = $path;
        }

        Post::create([
            'title' => $request->title,
            'about' => $request->about,
            'price' => $request->price,
            'reduced_price' => $request->reduced_price,
            'category' => $request->category,
            'image' => $images,
            'user_id' => Auth::user()->id,
        ]);

        return 'success';
    }

    public function post_game()
    {
        return view('admin.games.post_game');
    }

    public function store_game(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'size' => 'required|string',
            'online_or_offline' => 'required|in:online,offline,Online/Offline',
            'logo' => 'required',
            'category' => 'required',
            'download_links' => 'required|json',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $images = [];
        try {
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    // Store each image
                    $path = $file->store('games_images', 'public');
                    $images[] = '/storage/' . $path;
                }
            } else {
                $images = json_decode($request->image, true);
            }
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('game_logos', 'public');
                $logo = '/storage/' . $path;
            }
        } catch (\Exception $e) {
            // Handle the error, e.g., log it, return a response, etc.
            return response()->json(['error' => 'Error storing images.'], 500);
        }

        try {
        $game = Game::create([
            'name' => $request->name,
            'about' => $request->about,
            'size' => $request->size,
            'online_or_offline' => $request->online_or_offline,
            'logo' => $logo,
            'category' => $request->category,
            'downloads' => "0",
            'download_links' => json_decode($request->download_links, true),
            'image' => $images,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()
            ->back()
            ->with('success', 'Game created successfully.')
            ->withInput();
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }

    public function games()
    {
        $games = Game::latest()->paginate(10);
        return view('admin.games.index', compact('games'));
    }

    public function edit_game_page($id)
    {
        $game = Game::findOrFail($id);
        return view('admin.games.edit', compact('game'));
    }

    public function update_game(Request $request, $id)
    {
        $game = Game::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'size' => 'required|string',
            'online_or_offline' => 'required|in:online,offline,Online/Offline',
            'logo' => 'required|string',
            'category' => 'required',
            'download_links' => 'required|json',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldImages = $game->image;
        $oldlogo = $game->logo;
        $logo = $game->logo;
        try {
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    // Store each new image
                    $path = $file->store('games_images', 'public');
                    $newImages[] = '/storage/' . $path;
                }
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $oldImage));
                }
            } else {
                $newImages = json_decode($request->image);
            }
            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('game_logos', 'public');
                $logo = '/storage/' . $path;
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
                'category' => $request->category,
                'download_links' => json_decode($request->download_links, true),
                'image' => $newImages,
                'user_id' => Auth::user()->id,
            ]);

            return redirect()
                ->back()
                ->with('success', 'Game updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }

    public function delete_game($id)
    {
        $game = Game::findOrFail($id);

        foreach ($game->image as $image) {
            $fileExists = Storage::disk('public')->exists(str_replace('/storage/', '', $image));

            if ($fileExists) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $image));
            }
        }
        // Delete the game
        $game->delete();

        return response()->json(['message' => 'Game deleted successfully']);
    }
}
