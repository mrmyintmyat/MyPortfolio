<?php

namespace App\Http\Controllers\Message;

use Log;
use App\Models\Post;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\MessagingSubscribe;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class FacebookWebhookController extends Controller
{
    public function verify(Request $request)
    {
        $hubChallenge = $request->input('hub_challenge');
        $hubVerifyToken = $request->input('hub_verify_token');

        // return 'ummm';
        // Your verification logic here
        \Log::error($hubVerifyToken);
        if ($hubVerifyToken === 'messengerPortfolio') {
            return response($hubChallenge, 200);
        }

        return response('Invalid verification token', 403);
    }

    public function webhook(Request $request)
    {
        $input = $request->all();
            $messages = [
                'I_want_to_buy' => 'ပို့ထားတာကိုတွေ့တာနဲ့ ကျွန်တော်တို့ဘက်က အမြန်ဆုံးပြန်ဆက်သွယ်ပေးပါ့မယ်ခင်ဗျာ တစ်ခြားမေးစရာရှိရင်လည်းမေးထားလို့ရပါတယ်ဗျ(We will contact you as soon as possible once we see it sent. If you have other questions, you can ask me!)
                ',
                'I_dont_want_to_buy' => 'အိုခေနားစား တစ်ခြားမေးစရာရှိရင်လည်းမေးထားလို့ရပါတယ်ဗျ(Thank you for contacting us. If you have other questions, you can ask me!)',
            ];

            \Log::error($input);

            if (isset($input['object']) && $input['object'] === 'page') {
                foreach ($input['entry'] as $entry) {
                    foreach ($entry['messaging'] as $event) {
                        $senderId = $event['sender']['id'];
                        Cache::put('senderId', $senderId);

                        if (isset($event['message']['attachments'][0]['type']) && $event['message']['attachments'][0]['type'] === 'image') {
                            // Handle image attachment
                            // You can access the image URL like this:
                            $imageUrl = $event['message']['attachments'][0]['payload']['url'];

                            // Respond to the image message, e.g., acknowledge receipt
                            $response_text = 'Received an image: ' . $imageUrl;
                        } else {
                            if (isset($event['message']['quick_reply']['payload'])) {
                                $payload = $event['message']['quick_reply']['payload'];
                                $response_text = $messages[$payload];
                            } else {
                                $messageText = $event['message']['text'];
                                $response_text = 'You said: ' . $messageText;
                            }
                        }

                        // Send a response_text
                        $gg = $this->sendTextMessage($senderId, $response_text);
                        if (!$gg) {
                            return response('EVENT_RECEIVED', 200);
                        } else {
                            \Log::error($gg);
                            return $gg . '<br>' . $senderId . '<br>' . $messageText;
                        }
                    }
                }
            }

            return 'ummm';
    }

    private function sendTextMessage($recipientId, $messageText)
    {
        $pageAccessToken = 'EAAEHjOfhmfYBOyQirVzJ6KW4gISziIxX17kWCiL7BC0fMOxwHYI7Hs498W0SlZC0ZAAmrTVXe82ZAUTFFAtlZBPNy4SFMl3MOMZB2z35Eay160ZCjRs18zDKqQgW40StqJDylWkrEooMCmbvbzhJx2izWxDYkI5MepneHVr61J1o4pOoDLp3D2e5Ae2OA3UkaX'; // Replace with your actual Page Access Token

        $client = new Client();

        $data = [
            'recipient' => ['id' => $recipientId],
            'message' => ['text' => $messageText],
        ];

        try {
            $response = $client->post('https://graph.facebook.com/v18.0/me/messages', [
                'query' => ['access_token' => $pageAccessToken],
                'json' => $data,
            ]);

            // Check the response and handle any errors if necessary
            $responseBody = $response->getBody()->getContents();
            return false;
            // You can log or process the response as needed
        } catch (\Exception $e) {
            // Handle any exceptions, e.g., log the error
            return $e->getMessage();
        }
    }
}
