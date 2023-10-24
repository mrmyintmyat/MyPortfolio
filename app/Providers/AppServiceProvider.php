<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('formatCurrency', function ($expression) {
            return "<?php
                \$price = preg_replace('/[^0-9]/', '', $expression);
                \$symbol = str_replace(\$price, '', $expression);
                \$formatted = number_format(\$price);
                echo \$formatted . (\$symbol ? \$symbol . ' ' : '');
            ?>";
        });
    }
}
