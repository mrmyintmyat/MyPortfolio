<?php

namespace App\Http\Controllers\Shop;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ShopController extends Controller
{
    public function index()
    {
      $items = Post::all();
      return view('shop.index', compact('items'));
    }

    public function show($id){
        $items = Post::find($id);
    }

    public function get_info(Request $request)
    {
        $id = $request->input('id');
        $item = Post::find($id);
        $html = view('results.item_info', ['item' => $item])->render();
        return response()->json(['html' => $html]);
    }
}
