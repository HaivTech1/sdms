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
                'users/author-one.jpg',
                '2349066100815',
                'ADM/22/311464'
            ),
            $this->createUser(
                'Mr',
                'Ojo Boluwatife',
                'ojotifeema@gmail.com',
                bcrypt('password'),
                User::SUPERADMIN,
                'users/author-two.jpg',
                '2348139636506',
                'ADM/22/311463'
            ),
            $this->createUser(
                'Mr',
                'Akinnusi Iyanuoluwa',
                'iyanuoluwa@gmail.com',
                bcrypt('password'),
                User::TEACHER,
                'users/author-two.jpg',
                '2349066100815',
                'ADM/22/311453'
            ),
            $this->createUser(
                'Mrs',
                'Obayomi Oluwaseun',
                'oluwaseun@gmail.com',
                bcrypt('password'),
                User::TEACHER,
                'users/author-two.jpg',
                '2349066100815',
                'ADM/22/312453'
            ),
            $this->createUser(
                'Mrs',
                'Olubunmi Adesodun',
                'bunmi@gmail.com',
                bcrypt('password'),
                User::BURSAL,
                'users/author-two.jpg',
                '2349066100815',
                'ADM/22/311353'
            ),
        ]);

        // $user->ownedTeams()->save(Team::forceCreate([
        //     'user_id' => $user->id,
        //     'name' => 'Housing Team',
        //     'personal_team' => true,
        // ]));
    }

    private function createUser(string $title, string $name, string $email, string $password, string $type, string $profile_photo_path, string $phone_number, string $reg_no)
    {
        return User::factory()->create(compact('title', 'name', 'email', 'password', 'type', 'profile_photo_path', 'phone_number', 'reg_no'));
    }
}