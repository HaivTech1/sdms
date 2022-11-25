<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();
        $schedules = Schedule::all();

        $schedules->each(function ($schedule) use ($students) {
          $schedule->students()->attach($students);
        });
    }
}
