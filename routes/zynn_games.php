<?php
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Game\GameController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Scrap\ScrapAn1Controller;
use App\Http\Controllers\Game\DetailPageController;
use App\Http\Controllers\WebCmNotificationController;
use App\Http\Controllers\Game\IncrementGameController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\GameController as AdminGameController;

//auth
$registerEnabled = Settings::first()->register ?? true;

Auth::routes([
    'verify' => true,
    'register' => $registerEnabled,
]);

Route::post('/logout', function (Request $request): RedirectResponse {
    Auth::user()->update([
        'is_logged_in' => false,
        'device_token' => null,
    ]);

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');
//admin panel
Route::group(['middleware' => ['auth', 'checkadmin']], function () {
    // Route::get('/admin/panel/games/create', [AdminController::class, 'post_game']);
    // Route::post('/admin/panel/games/store', [AdminController::class, 'store_game']);
    // Route::get('/admin/panel/games', [AdminController::class, 'games']);
    // Route::get('/admin/panel/games/{id}', [AdminController::class, 'edit_game_page']);
    // Route::delete('/admin/panel/games/{id}', [AdminController::class, 'delete_game']);
    // Route::post('/admin/panel/games/update/{id}', [AdminController::class, 'update_game']);
    Route::get('/admin/panel/games/view/{id}', [AdminGameController::class, 'view_game']);
    Route::get('/admin/panel/home', [AdminGameController::class, 'home'])->name('home');
    Route::get('/admin/panel/scrap/an1', [ScrapAn1Controller::class, 'index'])->name('scrapan1.index');
    Route::post('/admin/panel/scrap/an1', [ScrapAn1Controller::class, 'edit'])->name('scrapan1.edit');
    Route::post('/admin/panel/scrap/an1/store', [ScrapAn1Controller::class, 'store'])->name('scrapan1.store');
    Route::resource('/admin/panel/games', AdminGameController::class);
});

Route::group(['middleware' => ['check.site.status']], function () {
    Route::get('/', [GameController::class, 'index'])->name('games_index');
    // Route::get('/{category}', [GameController::class, 'oldGames'])->name('oldGames');
    Route::post('/games/search/1/2', [GameController::class, 'games_search'])->name('games_search');
    Route::get('/games/search/1/2', [GameController::class, 'games_search_scroll'])->name('games_search_scroll');
    Route::get('/{name}', [GameController::class, 'profile'])->name('profile');

    Route::get('/{user_name}/{id}/{name}', function ($user_name, $id, $name) {
        return Redirect::to("https://$name.zynn.games/$user_name/$id");
    });

    Route::get('/{id}/{name}', function ($id, $name) {
        return Redirect::to("https://$name.zynn.games/$id");
    });

    // Route::post('/{user_name}/{id}/{name}', [GameController::class, 'post_comment'])->name('post_comment');
    // Route::post('/send_message', [PortfolioController::class, 'storeMessage'])->secure();

    Route::post('/store-token', [WebCmNotificationController::class, 'storeToken'])->name('store.token');

    Route::post('/request-admin', [GameController::class, 'reqadmin'])->name('req.admin');

    Route::put('/update-profile', [UserController::class, 'update'])->name('update.profile');

    Route::get('/privacy-policy', [GameController::class, 'privacy_policy']);
});

$webUrl = env('WEB_URL', 'localhost');
$domain = '{subdomain}.' . $webUrl;

Route::group(['middleware' => ['check.site.status'], 'domain' => $domain], function () {
    Route::get('/{id}', [DetailPageController::class, 'detail'])->name('games.detail');
    Route::get('/{user_name}/{id}', [DetailPageController::class, 'user_game_detail'])->name('games.user.detail');
    Route::post('/{user_name}/{id}', [GameController::class, 'post_comment'])->name('post_comment');
    Route::resource('/increment-downloads', IncrementGameController::class)->only(['store']);
});
