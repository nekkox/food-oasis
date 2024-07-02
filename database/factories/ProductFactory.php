<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryCount = Category::count();
        $categoryId = $categoryCount > 0 ? Category::inRandomOrder()->first()->id : null;
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'thumb_image' => '/uploads/test.jpg',
            'category_id' =>  $categoryId, // Assuming you have a CategoryFactory
            'short_description' => $this->faker->paragraph(),
            'long_description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 1, 200),
            'offer_price' => $this->faker->randomFloat(2, 1, 100),
            'sku' => $this->faker->unique()->ean13(),
            'seo_title' => $this->faker->sentence,
            'seo_description' => $this->faker->paragraph(),
            'show_at_home' => $this->faker->boolean,
            'status' => $this->faker->boolean,
        ];
    }
}
