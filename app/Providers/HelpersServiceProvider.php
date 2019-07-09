<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        require app_path('Helpers/helpers.php');
        require app_path('Helpers/macros.php');
        require app_path('Helpers/strings.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
