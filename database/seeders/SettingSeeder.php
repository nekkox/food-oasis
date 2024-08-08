<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'id' => 1,
                'key' => 'site_name',
                'value' => 'New Site Name',
                'created_at' => null,
                'updated_at' => '2024-07-05 18:00:40',
            ],
            [
                'id' => 2,
                'key' => 'site_default_currency',
                'value' => 'USD',
                'created_at' => '2024-07-05 11:42:30',
                'updated_at' => '2024-07-17 18:48:31',
            ],
            [
                'id' => 3,
                'key' => 'site_currency_icon',
                'value' => '$',
                'created_at' => '2024-07-05 11:42:30',
                'updated_at' => '2024-07-17 18:48:31',
            ],
            [
                'id' => 4,
                'key' => 'site_currency_icon_position',
                'value' => 'left',
                'created_at' => '2024-07-05 11:42:30',
                'updated_at' => '2024-07-05 21:53:23',
            ],
            [
                'id' => 5,
                'key' => 'pusher_app_id',
                'value' => '1837524',
                'created_at' => '2024-07-22 10:20:25',
                'updated_at' => '2024-07-22 10:20:25',
            ],
            [
                'id' => 6,
                'key' => 'pusher_key',
                'value' => '20899582e543a6503ba2',
                'created_at' => '2024-07-22 10:20:25',
                'updated_at' => '2024-07-22 10:20:25',
            ],
            [
                'id' => 7,
                'key' => 'pusher_secret',
                'value' => 'e0d819a69167c6b1d984',
                'created_at' => '2024-07-22 10:20:25',
                'updated_at' => '2024-07-22 10:20:25',
            ],
            [
                'id' => 8,
                'key' => 'pusher_cluster',
                'value' => 'eu',
                'created_at' => '2024-07-22 10:20:25',
                'updated_at' => '2024-07-22 10:20:25',
            ],
            [
                'id' => 9,
                'key' => 'mail_driver',
                'value' => 'smtp',
                'created_at' => '2024-07-31 12:02:15',
                'updated_at' => '2024-07-31 12:02:15',
            ],
            [
                'id' => 10,
                'key' => 'mail_host',
                'value' => 'sandbox.smtp.mailtrap.io',
                'created_at' => '2024-07-31 12:02:15',
                'updated_at' => '2024-07-31 12:02:15',
            ],
            [
                'id' => 11,
                'key' => 'mail_port',
                'value' => '2525',
                'created_at' => '2024-07-31 12:02:15',
                'updated_at' => '2024-07-31 12:02:15',
            ],
            [
                'id' => 12,
                'key' => 'mail_username',
                'value' => 'fefb12b5b90b01',
                'created_at' => '2024-07-31 12:02:15',
                'updated_at' => '2024-07-31 12:02:15',
            ],
            [
                'id' => 13,
                'key' => 'mail_password',
                'value' => 'e5012204a9e57f',
                'created_at' => '2024-07-31 12:02:15',
                'updated_at' => '2024-07-31 12:02:15',
            ],
            [
                'id' => 14,
                'key' => 'mail_encryption',
                'value' => 'null',
                'created_at' => '2024-07-31 12:02:15',
                'updated_at' => '2024-07-31 12:02:15',
            ],
            [
                'id' => 15,
                'key' => 'mail_from_address',
                'value' => 'vvvvv@example.com',
                'created_at' => '2024-07-31 12:02:15',
                'updated_at' => '2024-07-31 16:34:33',
            ],
            [
                'id' => 16,
                'key' => 'mail_receive_address',
                'value' => 'vvvvv@example.com',
                'created_at' => '2024-07-31 12:02:15',
                'updated_at' => '2024-07-31 19:46:56',
            ],
            [
                'id' => 17,
                'key' => 'logo',
                'value' => 'uploads/media_66b36125d3a72.png',
                'created_at' => '2024-08-06 15:18:50',
                'updated_at' => '2024-08-07 11:57:25',
            ],
            [
                'id' => 18,
                'key' => 'footer_logo',
                'value' => 'uploads/media_66b23eda5df73.jpg',
                'created_at' => '2024-08-06 15:18:50',
                'updated_at' => '2024-08-06 15:18:50',
            ],
            [
                'id' => 19,
                'key' => 'favicon',
                'value' => 'uploads/media_66b23eda5f4ed.jpg',
                'created_at' => '2024-08-06 15:18:50',
                'updated_at' => '2024-08-06 15:18:50',
            ],
            [
                'id' => 20,
                'key' => 'breadcrumb',
                'value' => 'uploads/media_66b23eda60a46.jpg',
                'created_at' => '2024-08-06 15:18:50',
                'updated_at' => '2024-08-06 15:18:50',
            ],
            [
                'id' => 21,
                'key' => 'site_email',
                'value' => 'klascibox@gmail.com',
                'created_at' => '2024-08-07 11:53:33',
                'updated_at' => '2024-08-07 11:53:33',
            ],
            [
                'id' => 22,
                'key' => 'site_phone',
                'value' => '555-666-3333',
                'created_at' => '2024-08-07 11:53:33',
                'updated_at' => '2024-08-07 11:53:33',
            ],
            [
                'id' => 23,
                'key' => 'site_color',
                'value' => '#e15829',
                'created_at' => '2024-08-07 12:08:09',
                'updated_at' => '2024-08-07 12:16:52',
            ],
            [
                'id' => 24,
                'key' => 'seo_title',
                'value' => 'Food Park',
                'created_at' => '2024-08-07 13:58:27',
                'updated_at' => '2024-08-07 13:58:27',
            ],
            [
                'id' => 25,
                'key' => 'seo_description',
                'value' => null,
                'created_at' => '2024-08-07 13:58:27',
                'updated_at' => '2024-08-07 13:58:27',
            ],
        ];

        DB::table('settings')->insert($settings);
    }
}
