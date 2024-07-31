<?php

namespace App\Providers;

use App\Models\Setting;
use App\Services\CustomMailService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CustomMailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CustomMailService::class, function(){
            return new CustomMailService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // make an instance of a class, and Laravel will automatically inject its dependencies.
        $customMailSetting = $this->app->make(CustomMailService::class);
        $customMailSetting->setGlobalSettings();

    }
}
