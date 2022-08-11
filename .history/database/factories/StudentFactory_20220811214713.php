<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Grade;
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
            'gender'                => $this->faker->randomElement(['male', 'female', 'others']),
            'dob'                   => now(),
            'nationality'           => 'Nigerian',
            'state_of_origin'       => $this->faker->randomElement(['Ogun', 'Lagos', 'Oyo']) . ' State',
            'local_government'      => $this->faker->randomElement(['Ibadan', 'Abeokuta', 'Obalende']) . ' State' . $this->faker->randomElement(['North', 'South', 'East', 'West']),
            'address'               => $this->faker->address(),
            'prev_school'           => $this->faker->word(),
            'prev_class'            => $this->faker->word(),
            'medical_history'       => $this->faker->paragraph(100),
            'allergics'             => $this->faker->paragraph(100),
            'image'                 => 'author-'. $this->faker->randomElement(['one', 'two', 'three', 'four']) . '.jpg',
            'grade_id'              => $attribute['grade_id'] ?? Grade::factory(),
            'author_id'             => $attribute['author_id'] ?? User::factory(),
        ];
    }
}