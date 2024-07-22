<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{

    public function getSettings()
    {
        return Cache::rememberForever('settings', function () {
          return Setting::pluck('value', 'key')->toArray();
        });
    }

    public function setGlobalSettings()
    {
        $settings = $this->getSettings();

        config()->set('settings', $settings);


    }

    public function clearCachedSettings()
    {
        Cache::forget('settings');
    }
}
