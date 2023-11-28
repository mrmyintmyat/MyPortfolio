<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(){
        return view('index');
    }

    public function send_message(Request $request){
        try {
            $message = Message::create($request->all());
            return response()->json(['Done' => 'Message sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); // HTTP status code 500 for internal server error
        }
    }
}
//gg
