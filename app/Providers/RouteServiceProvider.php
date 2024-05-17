<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\Game\GameController;
use App\Http\Controllers\Game\DetailPageController;
use App\Http\Controllers\Game\IncrementGameController;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin/panel/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // $this->app['router']->pattern('subdomain', '[a-zA-Z0-9]+');

        // $this->app['router']->bind('subdomain', function ($subdomain) {
        //     // Set the session domain to the current subdomain
        //     config(['session.domain' => $subdomain . '.localhost']);

        //     return $subdomain;
        // });

        $this->routes(function () {
            Route::domain('games.localhost')
                ->middleware(['web'])
                ->group(base_path('routes/zynn_games.php'));

            Route::domain('games.myintmyat.dev')
                ->middleware(['web'])
                ->group(base_path('routes/mma_subdomain_web.php'));

            // Route::group(['domain' => '{subdomain}.localhost'], function () {
            //     Route::get('/{id}', [DetailPageController::class, 'detail'])->name('games.detail');
            //     Route::get('/{user_name}/{id}', [DetailPageController::class, 'user_game_detail'])->name('games.user.detail');
            //     Route::post('/{user_name}/{id}', [GameController::class, 'post_comment'])->name('post_comment');
            //     Route::resource('/increment-downloads', IncrementGameController::class)->only(['store']);
            // });

            // Route::domain('{subdomain}.localhost')->group(function () {

            // });
            // Route::domain('zynn.games')
            //     ->middleware(['web'])
            //     ->group(base_path('routes/zynn_games.php'));

            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));

            Route::middleware('web')->group(base_path('routes/web.php'));
        });
    }
}
