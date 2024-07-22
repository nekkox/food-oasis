<?php

namespace App\Providers;


use App\Models\Setting;
use Illuminate\Support\Facades\Gate;
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

        //Getting Pusher credentials from database
        $values = ['pusher_app_id', 'pusher_key', 'pusher_secret','pusher_cluster'];
        $pusherConf = Setting::whereIn('key', $values)->get()->pluck('value','key');

        config(['broadcasting.connections.pusher.key' => $pusherConf['pusher_key']]);
        config(['broadcasting.connections.pusher.secret' => $pusherConf['pusher_secret']]);
        config(['broadcasting.connections.pusher.app_id' => $pusherConf['pusher_app_id']]);
        config(['broadcasting.connections.pusher.options.cluster' => $pusherConf['pusher_cluster']]);
    }
}
