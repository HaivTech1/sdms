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
                'title' => 'Admin',
            ],
            [
                'id'    => 2,
                'title' => 'Secretary',
            ],
            [
                'id'    => 3,
                'title' => 'Class Teacher',
            ],
            [
                'id'    => 4,
                'title' => 'Subject Teacher',
            ],
            [
                'id'    => 5,
                'title' => 'Student',
            ],
        ];

        Role::insert($roles);
    }
}