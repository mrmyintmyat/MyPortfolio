<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Game\GameController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Game\DetailPageController;
use App\Http\Controllers\WebCmNotificationController;
use App\Http\Controllers\Game\IncrementGameController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\GameController as AdminGameController;

//auth
Auth::routes([
    'verify' => true,
]);
Route::post('/logout', function () {
    Auth::user()->update(
        [
         'is_logged_in' => false,
        ]
    );
    auth()->logout();

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
    Route::resource('/admin/panel/games', AdminGameController::class);
});

Route::get('/', [GameController::class, 'index'])->name('games_index');
// Route::get('/{category}', [GameController::class, 'oldGames'])->name('oldGames');
Route::post('/games/search/1/2', [GameController::class, 'games_search'])->name('games_search');
Route::resource('/increment-downloads', IncrementGameController::class)->only(['store']);
Route::get('/games/search/1/2', [GameController::class, 'games_search_scroll'])->name('games_search_scroll');
Route::get('/{name}', [GameController::class, 'profile'])->name('profile');

Route::get('/{user_name}/{id}/{name}', [DetailPageController::class, 'user_game_detail'])->name('games_detail');

Route::get('/{id}/{name}', [DetailPageController::class, 'detail']);

Route::post('/{user_name}/{id}/{name}', [GameController::class, 'post_comment'])->name('post_comment');

Route::post('/store-token', [WebCmNotificationController::class, 'storeToken'])->name('store.token');

Route::put('/update-profile', [UserController::class, 'update'])->name('update.profile');

Route::get('/privacy-policy', [GameController::class, 'privacy_policy']);
