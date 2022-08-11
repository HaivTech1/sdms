<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\GradeSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\BookingSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\StudentSeeder;
use Database\Seeders\SubjectSeeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\UserTableSeeder;
use Database\Seeders\ApplicationSeeder;
use Database\Seeders\PostCategorySeeder;
use Database\Seeders\ProductCategorySeeder;
use Database\Seeders\PropertyCategorySeeder;

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
        $this->call(GradeSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(StudentSeeder::class);
    }
}