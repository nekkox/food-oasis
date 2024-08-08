<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentGatewaySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_gateway_settings = [
            [
                'id' => 1,
                'key' => 'paypal_logo',
                'value' => '/uploads/media_669ac176d0cf4.png',
                'created_at' => '2024-07-16 17:25:46',
                'updated_at' => '2024-07-19 19:41:42',
            ],
            [
                'id' => 2,
                'key' => 'paypal_status',
                'value' => '1',
                'created_at' => '2024-07-16 17:25:46',
                'updated_at' => '2024-07-19 20:09:39',
            ],
            [
                'id' => 3,
                'key' => 'paypal_account_mode',
                'value' => 'sandbox',
                'created_at' => '2024-07-16 17:25:46',
                'updated_at' => '2024-07-16 20:56:16',
            ],
            [
                'id' => 4,
                'key' => 'paypal_country',
                'value' => 'BO',
                'created_at' => '2024-07-16 17:25:46',
                'updated_at' => '2024-07-16 21:40:06',
            ],
            [
                'id' => 5,
                'key' => 'paypal_currency',
                'value' => 'USD',
                'created_at' => '2024-07-16 17:25:46',
                'updated_at' => '2024-07-17 18:49:09',
            ],
            [
                'id' => 6,
                'key' => 'paypal_rate',
                'value' => '1',
                'created_at' => '2024-07-16 17:25:46',
                'updated_at' => '2024-07-17 18:49:09',
            ],
            [
                'id' => 7,
                'key' => 'paypal_api_key',
                'value' => 'AaBPptdEn_UDZ3BvOU7ZCupHc0M1TZv3GtzJisn593fQ092p4gnpugqV20uJNm2CMajTdFRF2eLXKXuq',
                'created_at' => '2024-07-16 17:25:46',
                'updated_at' => '2024-07-18 22:39:51',
            ],
            [
                'id' => 8,
                'key' => 'paypal_secret_key',
                'value' => 'EHWOSpEIbDT2PoLh4T-kfywG9z7NRyycdDGeUut2Y1ApCc_3XdNn1d7d3EJTsSnzECTGAn0zbTaJP4m3',
                'created_at' => '2024-07-16 17:25:46',
                'updated_at' => '2024-07-18 22:47:32',
            ],
            [
                'id' => 9,
                'key' => 'paypal_app_id',
                'value' => '22',
                'created_at' => '2024-07-19 12:16:38',
                'updated_at' => '2024-07-19 12:16:38',
            ],
            [
                'id' => 10,
                'key' => 'stripe_logo',
                'value' => '/uploads/media_669a783d98a1c.png',
                'created_at' => '2024-07-19 14:29:17',
                'updated_at' => '2024-07-19 14:29:17',
            ],
            [
                'id' => 11,
                'key' => 'stripe_status',
                'value' => '1',
                'created_at' => '2024-07-19 14:29:17',
                'updated_at' => '2024-07-19 20:09:44',
            ],
            [
                'id' => 12,
                'key' => 'stripe_country',
                'value' => 'BT',
                'created_at' => '2024-07-19 14:29:17',
                'updated_at' => '2024-07-19 19:57:07',
            ],
            [
                'id' => 13,
                'key' => 'stripe_currency',
                'value' => 'USD',
                'created_at' => '2024-07-19 14:29:17',
                'updated_at' => '2024-07-19 14:29:17',
            ],
            [
                'id' => 14,
                'key' => 'stripe_rate',
                'value' => '0',
                'created_at' => '2024-07-19 14:29:17',
                'updated_at' => '2024-07-19 14:29:17',
            ],
            [
                'id' => 15,
                'key' => 'stripe_api_key',
                'value' => 'pk_test_51PeIhsRtwyyXcBTLHcyCreTU7R6brxPEOuSrxwpQExWcfAWCwc0P8t4rnZdTG2b1xgi0HdMKQtazIgEBMzHghpjq00BGWeQ3oX',
                'created_at' => '2024-07-19 14:29:17',
                'updated_at' => '2024-07-19 15:30:08',
            ],
            [
                'id' => 16,
                'key' => 'stripe_secret_key',
                'value' => 'sk_test_51PeIhsRtwyyXcBTLeejRvlh0tfSnob4k98XsAwW9NgiFThFuTGLGZkX7VVOUNuuPzvg0hjxItG64oJoX7ETiye1t00ATnKUWXb',
                'created_at' => '2024-07-19 14:29:17',
                'updated_at' => '2024-07-19 15:30:08',
            ],
        ];

        DB::table('payment_gateway_settings')->insert($payment_gateway_settings);
    }
}
