<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use App\Models\Grade;
use App\Models\House;
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
        $name = $this->faker->word();

        return [
            'first_name'             => $name,
            'last_name'             => $name,
            'other_name'             => $name,
            'gender'                => $this->faker->randomElement(['male', 'female']),
            'dob'                   => now(),
            'nationality'           => 'Nigerian',
            'state_of_origin'       => $this->faker->randomElement(['Ogun', 'Lagos', 'Oyo']) . ' State',
            'local_government'      => $this->faker->randomElement(['Ibadan', 'Abeokuta', 'Obalende']) . $this->faker->randomElement(['North', 'South', 'East', 'West']),
            'address'               => $this->faker->address(),
            'prev_school'           => $this->faker->word(),
            'prev_class'            => $this->faker->word(),
            'medical_history'       => $this->faker->paragraph(30),
            'allergics'             => $this->faker->paragraph(30),
            'grade_id'              => $attribute['grade_id'] ?? Grade::factory(),
            'house_id'              => $attribute['house_id'] ?? House::factory(),
            'club_id'              => $attribute['club_id'] ?? Club::factory(),
            'user_id'               => $attribute['user_id'] ?? User::factory(),
            'author_id'             => $attribute['author_id'] ?? User::factory(),
        ];
    }
}