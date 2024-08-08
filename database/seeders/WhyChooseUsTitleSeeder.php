<?php

namespace Database\Seeders;

use App\Models\SectionTitle;
use App\Models\WhyChooseUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WhyChooseUsTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
/*        SectionTitle::insert([
            [
                'key' => 'why_choose_us_top_title',
                'value' => 'Why Choose Us'
            ],
            [
                'key' => 'why_choose_us_main_title',
                'value' => 'Why Choose Us'
            ],
            [
                'key' => 'why_choose_us_sub_title',
                'value' => 'Objectively pontificate quality models before intuitive information. Dramatically recaptiualize multifunctional materials.'
            ]
        ]);*/

        $why_choose_us = [
            [
                'id' => 1,
                'icon' => 'fas fa-percent',
                'title' => 'discount voucherz',
                'short_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, debitis expedita .',
                'status' => 1,
                'created_at' => '2024-06-30 13:09:45',
                'updated_at' => '2024-06-30 13:44:40',
            ],
            [
                'id' => 2,
                'icon' => 'fab fa-apple',
                'title' => 'fresh healthy foods',
                'short_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, debitis expedita .',
                'status' => 1,
                'created_at' => '2024-06-30 13:11:48',
                'updated_at' => '2024-06-30 13:11:48',
            ],
            [
                'id' => 3,
                'icon' => 'fas fa-cookie',
                'title' => 'fast serve on table',
                'short_description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Est, debitis expedita .',
                'status' => 1,
                'created_at' => '2024-06-30 13:12:15',
                'updated_at' => '2024-06-30 13:12:15',
            ],
        ];

        DB::table('why_choose_us')->insert($why_choose_us);


    }
}

