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
    public function definition()
    {
        return [
            'full_name'             => $this->faker->name(),
            'email'                 => $this->faker->email(),
            'phone_number'          => $this->faker->phoneNumber(),
            'occupation'            => $this->faker->word(),
            'office_address'        => $this->faker->address(),
            'home_address'          => $this->faker->address(),
            'relationship'          => $this->faker->randomElement(['Father', 'Mother', 'Siblings']),
            'student_id'              => $attribute['student_id'] ?? Student::factory(),
        ];
    }
}