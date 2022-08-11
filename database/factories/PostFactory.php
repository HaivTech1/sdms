<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();

        return [
            'title'             => $title,
            'slug'              => Str::slug($title . '-' . now()->getPreciseTimestamp(4)),
            'description'              => $this->faker->paragraph(100),
            'is_commentable'    => rand(0, 1),
            'image'             => 'stock-'. $this->faker->randomElement(['one', 'two', 'three', 'four']) . '.jpg',
            'published_at'      => now(),
            'type'              => $this->faker->randomElement(['standard', 'premium']),
            'post_category_id'         => $attribute['post_category_id'] ?? PostCategory::factory(),
            'author_id'         => $attribute['author_id'] ?? User::factory(),
        ];
    }
}