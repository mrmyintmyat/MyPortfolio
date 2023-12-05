<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Game\GameController;
use App\Http\Controllers\Game\IncrementGameController;

Route::get('/', [GameController::class, 'index'])->name('games_index');
Route::post('/search', [GameController::class, 'games_search'])->name('games_search');
Route::resource('/increment-downloads', IncrementGameController::class)->only(['store']);
Route::get('/search', [GameController::class, 'games_search_scroll'])->name('games_search_scroll');
Route::get('/{id}/{name}', [GameController::class, 'detail'])->name('games_detail');
