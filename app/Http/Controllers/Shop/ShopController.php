<?php

namespace App\Http\Controllers\Shop;

use App\Models\Post;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $items = Post::latest()
            ->paginate(10);

        if ($request->ajax()) {
            $page = $request->input('page');
            $items = Post::latest()
                ->paginate(10, ['*'], 'page', $page);

            return view('results.search-results', ['items' => $items])->render();
        }

        // $request->session()->put('sender_id', 'yo');
      return view('shop.index', compact('items'));
    }

    public function buy(Request $request){
        $id = $request->input('item_id');
        $item = Post::find($id);
        $messenger_user_id = Cache::get('senderId');
        $ok = $this->sendMessageToUser($item, $messenger_user_id);
        return $ok;
    }

    private function sendMessageToUser($item, $id)
    {
        // Your Page Access Token
        $pageAccessToken = 'EAAEHjOfhmfYBO6QN0ATe8h5xeV5yPUSLUMjTxzkSWBgJsjrfZCWqXz5cPPkWDCWQVqX6Yo4r8Rji20phI5AqjXXkSi95uvYaq0UTRb4HGqjECHRMPCsMpLnyA1OkSAKIvUA2ZABxo1mnRrA5RPi2stYMfhiFwyxJ5LwlpULYyYIXZC5QtrcJb9FdkZBgeU14';

        // Message you want to send
        $messageText = "
         Name = $item->title,
         Price = $item->price,
         Do you want to buy this product?
         Confirm it. (Yes or No)
        ";

        // Create the API URL for sending a message
        $apiUrl = "https://graph.facebook.com/v18.0/me/messages?access_token=$pageAccessToken";

        // Data to send
        $data = [
            'messaging_type' => 'RESPONSE',
            'recipient' => ['id' => $id],
            'message' => [
                'text' => $messageText,
                'quick_replies' => [
                    [
                        'content_type' => 'text',
                        'title' => 'YES',
                        'payload' => 'I_want_to_buy',
                    ],
                    [
                        'content_type' => 'text',
                        'title' => 'NO',
                        'payload' => 'I_dont_want_to_buy',
                    ],
                ],
            ],
        ];

        // Use the Laravel HTTP client to make the POST request
        $response = Http::post($apiUrl, $data);

        // Check the response for any errors or log it as needed
        $responseData = $response->json();

        return response()->json($responseData);
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

    public function search(Request $request)
    {
        $query = $request->input('query');

        $page = $request->input('search_nextPage');
        if ($page) {
            $items = Post::
                where('title', 'LIKE', '%' . $query . '%')
                ->latest()
                ->paginate(3, ['*'], 'page', $page);
            $html = view('results.search-results', ['items' => $items])->render();
            return response()->json(['html' => $html]);
        }

        $items = Post::where('title', 'LIKE', '%' . $query . '%')
            ->latest()
            ->paginate(3);

        $html = view('results.search-results', ['items' => $items])->render();
        return response()->json(['html' => $html]);
    }

    public function search_scroll(Request $request)
    {
        $query = $request->input('query');

        $page = $request->input('search_nextPage');
        if ($page) {
            $items = Post::
                where('title', 'LIKE', '%' . $query . '%')
                ->latest()
                ->paginate(3, ['*'], 'page', $page);
            $html = view('results.search-results', ['items' => $items])->render();
            return response()->json(['html' => $html]);
        }

        return redirect()->back();
    }
}
