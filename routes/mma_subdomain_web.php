<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Game\GameController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Game\IncrementGameController;
use App\Http\Controllers\Admin\GameController as AdminGameController;

Route::get('/{category?}', function ($category) {
    if ($category) {
        // Redirect to zynn.games with the category
        return Redirect::to("https://zynn.games/$category");
    } else {
        // Redirect to zynn.games without a category
        return Redirect::to("https://zynn.games");
    }
});
Route::get('/{id}/{name}', function ($id, $name) {
    return Redirect::to("https://zynn.games/$id/$name");
});
// Route::get('/{user_name}/{id}/{name}', function ($user_name, $id, $name) {
//     return Redirect::to("https://zynn.games/$user_name/$id/$name");
// });

