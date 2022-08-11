<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();

        return [
            'first_name'             => $name,
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