<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use App\Models\Agent;
use App\Models\Vendor;
use App\Models\Writer;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        $user = collect([
            $this->createUser(
                'Mr',
                'Shittu Oluwaseun',
                'shittuopeyemi24@gmail.com',
                bcrypt('midshot17'),
                User::SUPERADMIN,
                'author-one.jpg',
                '2349066100815'
            ),
            $this->createUser(
                'Mr',
                'Ojo Boluwatife',
                'ojotifeema@gmail.com',
                bcrypt('password'),
                User::SUPERADMIN,
                'author-two.jpg',
                '2348139636506'
            )
        ]);

        // $user->ownedTeams()->save(Team::forceCreate([
        //     'user_id' => $user->id,
        //     'name' => 'Housing Team',
        //     'personal_team' => true,
        // ]));
    }

    private function createUser(string $title, string $name, string $email, string $password, string $type, string $profile_photo_path, string $phone_number)
    {
        return User::factory()->create(compact('title', 'name', 'email', 'password', 'type', 'profile_photo_path', 'phone_number'));
    }
}