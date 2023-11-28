<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToFacebook()
    {

        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        print_r($user);
        $facebookUserId = $user->getId();
        $userAccessToken = $user->token;
        $facebookAccountLink = "https://www.facebook.com/profile.php?id={$facebookUserId}";

        return $facebookAccountLink;

        $pageAccessToken = 'EAAEHjOfhmfYBOxGXA2w0KsNIhpRGtQEdnLZBZCv1rUXYcPbG0xa87kwoSEJiR5UHpsr6oZAZCVFusfSMZCnZCJWRy9o6BESS6oC9AAtENwAzLg7ClEQ9zaDzianBH3ui3lSYWKgB6fkcV19afD5ltfCtjHFiw7FhyGTxzzn4PrcQMj3VkPjq0AWZBuZAuq6TmOaV94wZARYsLrVTFjtCSBd73CMcZD'; // Your Page Access Token

        // Recipient (User) ID
        $recipientId = '61551922417123'; // Replace with the recipient user's Facebook ID

        $messageData = [
            'recipient' => ['id' => $recipientId], // The recipient is the user's Facebook ID
            'message' => ['text' => 'Hello, world!'],
        ];

        $client = new Client();
        $response = $client->post('https://graph.facebook.com/v18.0/me/messages', [
            'query' => ['access_token' => $pageAccessToken],
            'json' => $messageData,
            'headers' => [
                'Authorization' => 'Bearer ' . $userAccessToken,
            ],
        ]);

        $responseBody = $response->getBody()->getContents();
        return $responseBody;
    }
}
