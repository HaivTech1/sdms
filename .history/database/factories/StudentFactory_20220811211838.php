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
            'last_name'             => $name,
            'other_name'             => $name,
            'gender'                => $this->faker->randomElement(['male', 'female', 'other']),
            'dob'                   => now(),
            'nationality'           => 'Nigerian',
            'state_of_origin'       => 'Ogun State',
            'local_government'      => 'Abeokuta North',
            'address'               => $this->faker->address(),
            'prev_school'           => $this->faker->word(),
            'prev_class'           => $this->faker->word(),
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