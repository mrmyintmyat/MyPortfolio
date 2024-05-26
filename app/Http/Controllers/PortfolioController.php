<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    public function index(){
        return view('index');
    }

    public function storeMessage(Request $request)
    {
        Log::error("1ok");
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email', // Ensure this is an email
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        Log::error("2ok");

        // Check if validation fails
        if ($validator->fails()) {
            Log::error("valerror");
            return response()->json(['errors' => $validator->errors()], 422); // HTTP status code 422 for Unprocessable Entity
        }

        try {
            // Create the message
            $message = Message::create([
                'name' => $request->name,
                'email_or_phone' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
            Log::error("OKK");
            return response()->json(['success' => 'Message sent successfully']);
        } catch (\Exception $e) {
            Log::error("NOOOOO");
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500); // HTTP status code 500 for internal server error
        }
    }
}
//gg
