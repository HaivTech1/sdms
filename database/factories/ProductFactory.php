<?php

namespace Database\Factories;

use App\Models\User;
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
            'discount'                 => $this->faker->numberBetween($min = 300, $max = 600),
            'qty'                     => rand(1, 10),
            'brand'                     =>  $this->faker->randomElement(['Adidas', 'Gucci', 'Lewis', 'Gramdor']), 
            'type'                     =>  $this->faker->randomElement(['clothing', 'furniture', 'wallpaper']),  
            'image'                 => json_encode('product-'. $this->faker->randomElement(['one', 'two', 'three', 'four']) . '.jpg'),
            'description'           => $this->faker->paragraph(5),
            'isAvailable'           => 1,
            'isVerified'            => 1,
            'product_category_id'  => $attribute['product_category_id'] ?? ProductCategory::factory(),
            'author_id'               => $attribute['author_id'] ?? User::factory(),
        ];
    }
}