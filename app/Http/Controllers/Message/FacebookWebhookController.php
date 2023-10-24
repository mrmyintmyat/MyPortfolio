<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\MessagingSubscribe;

class FacebookWebhookController extends Controller
{
    public function verify(Request $request)
    {
        $hubChallenge = $request->input('hub_challenge');
        $hubVerifyToken = $request->input('hub_verify_token');

        // Your verification logic here
        if ($hubVerifyToken === 'c5779df5170730ef77d90d9c7cf8852e') {
            return response($hubChallenge, 200);
        }

        return response('Invalid verification token', 403);
    }
}
