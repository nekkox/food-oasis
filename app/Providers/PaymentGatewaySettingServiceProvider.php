<?php

namespace App\Providers;


use App\Services\PaymentGatewaySettingService;
use Illuminate\Support\ServiceProvider;

class PaymentGatewaySettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->singleton(PaymentGatewaySettingService::class, function(){
            return new PaymentGatewaySettingService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // make an instance of a class, and Laravel will automatically inject its dependencies.
        $paymentGatewaySetting = $this->app->make(PaymentGatewaySettingService::class);

        $paymentGatewaySetting->setGlobalSettings();
    }
}
