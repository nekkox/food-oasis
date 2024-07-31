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
        $this->app->singleton(CustomMailService::class, function () {
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


                //Not creating CustomMailService

        /*        $mailSetting = Cache::rememberForever('mail_settings', function(){
                    $key = [
                        'mail_driver',
                        'mail_encryption',
                        'mail_from_address',
                        'mail_host',
                        'mail_password',
                        'mail_port',
                        'mail_receive_address',
                        'mail_username'
                    ];

                    return Setting::whereIn('key', $key)->pluck('value', 'key')->toArray();
                });

                if($mailSetting) {
                    Config::set('mail.mailers.smtp.host', $mailSetting['mail_host']);
                    Config::set('mail.mailers.smtp.port', $mailSetting['mail_port']);
                    Config::set('mail.mailers.smtp.encryption', $mailSetting['mail_encryption']);
                    Config::set('mail.mailers.smtp.username', $mailSetting['mail_username']);
                    Config::set('mail.mailers.smtp.password', $mailSetting['mail_password']);
                    Config::set('mail.from.address', $mailSetting['mail_from_address']);
                }*/
    }
}
