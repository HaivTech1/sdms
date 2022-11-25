<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Database\Seeder;

class GradeUser extends Seeder
{
    public function run()
    {
        $users = User::all();
        $grade = Grade::all();

        $users->each(function ($user) use ($grade) {
          $user->gradeClassTeacher()->attach($grade);
        });
    }
}
