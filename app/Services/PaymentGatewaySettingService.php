<?php

namespace App\Services;

use App\Models\PaymentGatewaySetting;
use Illuminate\Support\Facades\Cache;

class PaymentGatewaySettingService
{
    public function getSettings()
    {
        return Cache::rememberForever('gatewaySettings', function () {
            return PaymentGatewaySetting::pluck('value', 'key')->toArray();
        });
    }

    public function setGlobalSettings()
    {
        $settings = $this->getSettings();

        config()->set('gatewaySettings', $settings);



    }

    public function clearCachedSettings()
    {
        Cache::forget('gatewaySettings');
    }
}
