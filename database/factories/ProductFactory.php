<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->word();

        return [
            'title'                 => $title,
            'slug'                  => Str::slug($title . '-' . now()->getPreciseTimestamp(4)),
            'price'                 => $this->faker->numberBetween($min = 1500, $max = 6000),
            'quantity'                     => rand(1, 10),
            'image'                 => json_encode('product-'. $this->faker->randomElement(['one', 'two', 'three', 'four']) . '.jpg'),
            'description'           => $this->faker->paragraph(5),
            'status'                => 1,
            'category_id'           => $attribute['category_id'] ?? Category::factory(),
        ];
    }
}