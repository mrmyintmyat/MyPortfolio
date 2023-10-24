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
        $message = Message::create($request->all());
        return response()->json(['Done' => 'I will check it.']);
    }
}
