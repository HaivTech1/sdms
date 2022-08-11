<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GuardianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
        $name = $this->faker->name();

        return [
            'full_name'             => $name,
            'email'                 => $this->faker->email(),
            'phone_number'          => $this->faker->phone(),
            'office_address'        => $this->faker->address(),
            'home_address'          => $this->faker->address(),
            'relationship'          => $this->faker->randomElement(['Father', 'Mother', 'Siblings']),
            'image'                 => 'author-'. $this->faker->randomElement(['one', 'two', 'three', 'four']) . '.jpg',
            'grade_id'              => $attribute['grade_id'] ?? Grade::factory(),
            'author_id'             => $attribute['author_id'] ?? User::factory(),
        ];
}