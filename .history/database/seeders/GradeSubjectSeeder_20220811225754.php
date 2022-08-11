<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class GradeSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = Subject::all(); 
        $grades = Grade::all();

         $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => 'Housing Team',
            'personal_team' => true,
        ]));
    }
}