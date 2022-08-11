<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::factory()->count(20)->create(['author_id' => 1, 'grade_id' => 1])->guardian()->save(Guardian::factory()->make());
        Student::factory()->count(18)->create(['author_id' => 1, 'grade_id' => 2])->guardian()->save(Guardian::factory()->make());
        Student::factory()->count(15)->create(['author_id' => 1, 'grade_id' => 3])->guardian()->save(Guardian::factory()->make());
        Student::factory()->count(25)->create(['author_id' => 1, 'grade_id' => 4])->guardian()->save(Guardian::factory()->make());
        Student::factory()->count(16)->create(['author_id' => 1, 'grade_id' => 5])->guardian()->save(Guardian::factory()->make());
        Student::factory()->count(24)->create(['author_id' => 1, 'grade_id' => 6])->guardian()->save(Guardian::factory()->make());
        Student::factory()->count(20)->create(['author_id' => 1, 'grade_id' => 7])->guardian()->save(Guardian::factory()->make());
    }
}