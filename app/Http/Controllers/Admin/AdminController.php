<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Message;
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
        return view('admin.zynn.index');
    }
    
    public function require_games()
    {
        $public_games = Game::where('post_status', '=', 'Published')
            ->latest()
            ->paginate(18);
        $private_games = Game::where('post_status', '=', 'Private')
            ->Orwhere('post_status', '=', 'Reviewing')
            ->latest()
            ->paginate(18);
        return view('admin.zynn.games', compact('public_games', 'private_games'));
    }

    public function edit_games($id)
    {
        $game = Game::find($id);
        return view('admin.zynn.edit_game', compact('game'));
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

    public function mesages_for_me()
    {
        $messages = Message::all();
        return view('admin.messages', compact('messages'));
    }
}
