<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Guardian;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = Student::all();

        $posts->each(function ($students) {
            Guardian::factory()
                ->count(5)
                ->state(new Sequence(
                    fn () => [
                        'author_id'         => $users->random()->id,
                        'commentable_id'    => $post->id(),
                    ],
                ))
                ->create();
        });
    }
}