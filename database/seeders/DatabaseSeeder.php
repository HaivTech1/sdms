<?php

namespace Database\Seeders;

use Database\Seeders\GradeUser;
use Illuminate\Database\Seeder;
use Database\Seeders\ClubSeeder;
use Database\Seeders\TermSeeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\GradeSeeder;
use Database\Seeders\HouseSeeder;
use Database\Seeders\PeriodSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\SubjectSeeder;
use Database\Seeders\GuardianSeeder;
use Database\Seeders\ScheduleSeeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\ApplicationSeeder;
use Database\Seeders\GradeSubjectSeeder;
use Database\Seeders\ScheduleStudentSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ApplicationSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PeriodSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(TermSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(HouseSeeder::class);
        $this->call(ClubSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(GuardianSeeder::class);
        // $this->call(GradeSubjectSeeder::class);
        // $this->call(EventSeeder::class);
        // $this->call(GradeUser::class);
    }
}