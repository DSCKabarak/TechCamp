<?php

namespace App\Providers;

use App\Attendize\PaymentUtils;
use Illuminate\Support\Facades\Blade;
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
        require app_path('Helpers/strings.php');
        $this->paymentUtils();
    }

    /**
     * Add blade custom if for PaymentUtils
     *
     * @return void
     */
    public function paymentUtils()
    {
        Blade::if(
            'isFree',
            static function ($amount) {
                return PaymentUtils::isFree($amount);
            }
        );
        Blade::if(
            'requiresPayment',
            static function ($amount) {
                return PaymentUtils::requiresPayment($amount);
            }
        );
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
