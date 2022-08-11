<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $grades = Grade::all();

        $grades->each(function ($grade) use ($users) {
            Subject::factory()
                ->count(3)
                ->state(new Sequence(
                    fn () => [
                        'author_id'         => $users->random()->id,
                        'property_uuid'    => $property->id(),
                        'paymentStatus'    => 1,
                        'total'    => $property->price()
                    ],
                ))
                ->create();
        });
    }
}