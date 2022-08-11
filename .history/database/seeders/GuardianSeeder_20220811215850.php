<?php

namespace Database\Seeders;

use App\Models\Student;
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
            Comment::factory()
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