<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Game\GameController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Message\FacebookWebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// portfolio
Route::get('/', [PortfolioController::class, 'index']);
Route::post('/send_message', [PortfolioController::class, 'send_message'])->name('send_message');
Route::get('/privacy-policy', [HomeController::class, 'privacy_policy']);
Route::post('/post/info', [ShopController::class, 'get_info'])->name('get_info.data');

//auth
Auth::routes(['register' => false]);
//kk
//game
Route::domain('games.myintmyat.dev')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('games_index');
    Route::post('/search', [GameController::class, 'games_search'])->name('games_search');
    Route::post('/increment-downloads', [GameController::class, 'increment_downloads'])->name('games_increment');
    Route::get('/search', [GameController::class, 'games_search_scroll'])->name('games_search_scroll');
    Route::get('/{id}/{name}', [GameController::class, 'detail'])->name('games_detail');;
});
//shop
// Route::resource('/shop', ShopController::class);
// Route::post('/buy', [ShopController::class, 'buy']);
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/search', [ShopController::class, 'search']);
// Route::get('/search', [ShopController::class, 'search_scroll']);

//admin panel
Route::group(['middleware' => ['auth', 'checkstatus']], function () {
    // Route::get('/admin/users', [AdminController::class, 'showUsersPage'])->name('admin.users');
    Route::get('/admin/panel/games/create', [AdminController::class, 'post_game']);
    Route::post('/admin/panel/games/store', [AdminController::class, 'store_game']);
    Route::get('/admin/panel/games', [AdminController::class, 'games']);
    Route::get('/admin/panel/games/{id}', [AdminController::class, 'edit_game_page']);
    Route::delete('/admin/panel/games/{id}', [AdminController::class, 'delete_game']);
    Route::post('/admin/panel/games/update/{id}', [AdminController::class, 'update_game']);

    Route::resource('/admin/panel', AdminController::class);
});

//facebook login message
// Route::get('/webhook', [FacebookWebhookController::class, 'verify']);
// Route::post('/facebook/webhook', [FacebookWebhookController::class, 'handle']);
// Route::post('/webhook', [FacebookWebhookController::class, 'verify']);

// Route::get('auth/facebook', [LoginController::class, 'redirectToFacebook']);
// Route::get('auth/facebook/callback', [LoginController::class, 'handleFacebookCallback']);

// Route::post('/send-message-to-user', [FacebookWebhookController::class, 'sendMessageToPage']);
