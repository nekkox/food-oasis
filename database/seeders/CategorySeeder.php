<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Burger',
                'slug' => 'burger',
                'status' => 1,
                'show_at_home' => 1
            ],

            [
                'name' => 'Sandwitch',
                'slug' => 'sandwitch',
                'status' => 1,
                'show_at_home' => 1
            ],

            [
                'name' => 'Taco',
                'slug' => 'taco',
                'status' => 1,
                'show_at_home' => 1
            ],

        ]);
    }
}
