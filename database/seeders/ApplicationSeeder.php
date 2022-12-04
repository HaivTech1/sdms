<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $application = [
            [
            'id'        => 1,
            'name'      =>  'Haivtech Group of School',
            'alias'     =>  'CL',
            'email'     =>  'haivtech@gmail.com',
            'line1'        =>  '09066100815',
            'line2'        =>  '09066100815',
            'image'      =>  'applications/haivtech.png',
            'address'       =>  '10, Ona Abayo, Ondo, Ondo State',
            'motto'     =>  'Unique solutions for you',
            'slogan'        =>  'Unique solutions for you',
            'regNo'        =>  'RC2004222',
            'description'       =>  'Unique solutions for you',
            'facebook'        =>  'Haivtech',
            'instagram'        =>  'Haivtech',
            'twitter'        =>  'Haivtech',
            'linkedin'        =>  'Haivtech',
            'website'        =>  'https://www.haivtech.com.ng'
            ],
        ];
        
        Application::insert($application);
    }
}