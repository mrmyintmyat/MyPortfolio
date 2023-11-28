<?php

namespace App\Http\Controllers\Message;

use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;


class MessageController extends Controller
{
    public function webhook(Request $request)
    {
        $data = $request->all();
        Log::info('gg');
        // Process incoming messages here
        // You can access message data in $data['entry'][0]['messaging']

        foreach ($data['entry'] as $entry) {
            foreach ($entry['messaging'] as $messaging) {
                $senderId = $messaging['sender']['id'];
                $messageText = $messaging['message']['text'];

                // Process the received message and prepare your response
                $responseMessage = 'Hello! You said: ' . $messageText;

                // Send the response message
                $this->sendTextMessage($senderId, $responseMessage);
            }
        }

        return response('EVENT_RECEIVED', 200);
    }

    public function sendTextMessage($recipientId, $messageText)
    {
        $accessToken = 'EAAEHjOfhmfYBOyQirVzJ6KW4gISziIxX17kWCiL7BC0fMOxwHYI7Hs498W0SlZC0ZAAmrTVXe82ZAUTFFAtlZBPNy4SFMl3MOMZB2z35Eay160ZCjRs18zDKqQgW40StqJDylWkrEooMCmbvbzhJx2izWxDYkI5MepneHVr61J1o4pOoDLp3D2e5Ae2OA3UkaX';

        $client = new Client();

        try {
            $response = $client->post('https://graph.facebook.com/v18.0/me/messages', [
                'query' => ['access_token' => $accessToken],
                'json' => [
                    'recipient' => ['id' => $recipientId],
                    'message' => ['text' => $messageText],
                ],
            ]);

            // Check the HTTP status code for success
            if ($response->getStatusCode() === 200) {
                Log::info('Message sent successfully: ' . $response->getBody());
            } else {
                Log::error('Message sending failed with status code: ' . $response->getStatusCode());
            }
        } catch (RequestException $e) {
            // Handle Guzzle request exception
            Log::error('Error sending message: ' . $e->getMessage());
        }
    }
}
