<?php

namespace App\Http\Controllers\Scrap;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ScraperAnOneService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ScrapAn1Controller extends Controller
{
    protected $scraperService;

    public function __construct(ScraperAnOneService $scraperService)
    {
        $this->scraperService = $scraperService;
    }

    public function index(Request $request)
    {
        $url = "https://an1.com/?story=$request->name&do=search&subaction=search";
        $categories = Category::all();
        $games = $this->scraperService->scrapeSearchData($url);
        // return $games;
        return view('admin.games.scrapan1', compact('games', 'categories'));
    }

    public function edit(Request $request)
    {
        $user = Auth::user();

        $categories = Category::all();
        $game = $request->all();
        $game = (object) $game;
        $game->download_links = json_decode($game->download_links, true);
        $game->image = json_decode($game->image, true);
        // return $game;
        return view('admin.games.scrapan1Edit', compact('game', 'categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
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
            'online_or_offline' => 'required|in:online,offline,Online/Offline,unknow',
            'category' => 'required',
            'download_links' => 'required',
            'setting' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('logo')) {
            // Handle file upload
            $logoPath = $request->file('logo')->store('logos', 'public');
        } else {
            // Download logo from URL
            $logoUrl = $request->input('ExistLogo');
            $logoPath = $this->downloadImage($logoUrl, 'game_logos');
        }
        $logo = $logoPath;

        // Handle image uploads or downloads
        $imagePaths = [];
        if ($request->hasFile('newImage')) {
            // Handle file uploads
            foreach ($request->file('newImage') as $image) {
                $imagePath = $image->store('images', 'public');
                $imagePaths[] = $imagePath;
            }
        }

        // Handle existing images
        $existingImages = json_decode($request->input('Existimage'), true);
        foreach ($existingImages as $imageUrl) {
            $imagePaths[] = $this->downloadImage($imageUrl, 'games_images');
        }

        // $newImages = json_encode($imagePaths);

        if (Auth::user()->user_token == 2) {
            $post_status = 'Published';
        } else {
            $post_status = 'Reviewing';
        }
        try {
            Game::create([
                'name' => $request->name,
                'about' => $request->about,
                'size' => $request->size,
                'post_status' => $post_status,
                'online_or_offline' => $request->online_or_offline,
                'logo' => $logo,
                'category' => $category,
                'download_links' => $downloads_link,
                'downloads' => [0, 0, 0, 0, 0, 0, 0, 0],
                'image' => $imagePaths,
                'setting' => $setting,
                'user_id' => Auth::user()->id,
            ]);

            return response()->json(['success', 'Game updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }

    private function downloadImage($url, $directory)
    {
        $contents = file_get_contents($url);
        $name = basename($url);
        $path = "$directory/$name";
        Storage::disk('public')->put($path, $contents);

        return $path;
    }
}
