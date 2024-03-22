<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class WebCmNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function storeToken(Request $request)
    {
        try {
            if ($request->has('notok')) {
                auth()
                    ->user()
                    ->update(['setting' => ['notification' => false]]);
            } else {
                auth()
                    ->user()
                    ->update([
                        'device_token' => $request->token,
                        'setting' => ['notification' => true],
                    ]);
            }

            return response()->json(['message' => 'Token successfully stored.']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sendWebNotification($FcmToken, $title, $body, $link)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        // $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $serverKey = 'AAAA0eE45_c:APA91bH6oveSkSK-5OHxyQDeZuyLGvEnWM7Cb2582RgWNKGGLC-GmmqWc7rnnj4_Ppw9wfo9E7QWaOiLLDszz2sl8ZTzODotyP4sNR6_lScqKKPyAzHBhxf9-x9onTrZmSarxX_loi3H';

        $data = [
            'registration_ids' => $FcmToken,
            'data' => [
                'title' => $title,
                'body' => $body,
                'icon' => 'https://zynn.games/img/game_logo.png',
                'click_action' => $link,
            ],
        ];
        $encodedData = json_encode($data);

        $headers = ['Authorization:key=' . $serverKey, 'Content-Type: application/json'];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
    }
}
