<?php

namespace App\Providers;


use App\Models\Setting;
use App\Services\StatusUpdater;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
 /*       $this->app->singleton(StatusUpdater::class, function ($app) {
            return new StatusUpdater();
        });*/
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        //Getting Pusher credentials from database
        $values = ['pusher_app_id', 'pusher_key', 'pusher_secret','pusher_cluster'];
        $pusherConf = Setting::whereIn('key', $values)->get()->pluck('value','key');

        config(['broadcasting.connections.pusher.key' => $pusherConf['pusher_key']]);
        config(['broadcasting.connections.pusher.secret' => $pusherConf['pusher_secret']]);
        config(['broadcasting.connections.pusher.app_id' => $pusherConf['pusher_app_id']]);
        config(['broadcasting.connections.pusher.options.cluster' => $pusherConf['pusher_cluster']]);
        config(['broadcasting.connections.pusher.options.host' => 'api-'.$pusherConf['pusher_cluster'].'.pusher.com']);
    }
}
