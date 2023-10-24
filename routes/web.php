<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Shop\ShopController;
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

Route::resource('/', PortfolioController::class);
Route::post('/send_message', [PortfolioController::class, 'send_message'])->name('send_message');
Route::get('/privacy-policy', [HomeController::class, 'privacy_policy']);

Route::post('/post/info', [ShopController::class, 'get_info'])->name('get_info.data');

// Route::resource('/shop', ShopController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::post('/facebook/webhook', [FacebookWebhookController::class, 'handle']);
Route::post('/facebook/webhook', [FacebookWebhookController::class, 'handle']);
// routes/web.php

// Route::get('/webhook', [FacebookWebhookController::class, 'verify']);

// Route::get('/webhook', [MessageController::class, 'webhookVerification']);
Route::post('/webhook', [MessageController::class, 'webhook']);
