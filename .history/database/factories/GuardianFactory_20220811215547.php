<?php

namespace Database\Factories;

use App\Models\Student;
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
            'student_id'              => $attribute['student_id'] ?? Student::factory(),
        ];
}