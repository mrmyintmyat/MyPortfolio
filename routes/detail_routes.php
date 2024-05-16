<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Game\GameController;
use App\Http\Controllers\Game\DetailPageController;
use App\Http\Controllers\Game\IncrementGameController;

Auth::routes([
    'verify' => true,
]);

Route::get('/{id}', [DetailPageController::class, 'detail'])->name('games.detail');
Route::get('/{user_name}/{id}', [DetailPageController::class, 'user_game_detail'])->name('games.user.detail');
Route::post('/{user_name}/{id}', [GameController::class, 'post_comment'])->name('post_comment');
Route::resource('/increment-downloads', IncrementGameController::class)->only(['store']);
