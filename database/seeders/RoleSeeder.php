<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'SuperAdmin',
            ],
            [
                'id'    => 2,
                'title' => 'Admin',
            ],
            [
                'id'    => 3,
                'title' => 'Bursal',
            ],
            [
                'id'    => 4,
                'title' => 'Teacher',
            ],
            [
                'id'    => 5,
                'title' => 'Student',
            ],
        ];

        Role::insert($roles);
    }
}