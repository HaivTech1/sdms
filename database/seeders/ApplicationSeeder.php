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
            'name'      =>  'Colony',
            'alias'     =>  'CL',
            'email'     =>  'colony@gmail.com',
            'line1'        =>  '09066100815',
            'line2'        =>  '09066100815',
            'whatsapp'        =>  '09066100815',
            'instagram'        =>  'https://www.instagram.com/colony',
            'facebook'        =>  'https://www.facebook.com/colony',
            'image'      =>  'applications/colony.png',
            'address'       =>  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis',
            'motto'     =>  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis',
            'slogan'        =>  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis',
            'logistic'        =>  1500,
            'cleaning'        =>  1500,
            'regNo'        =>  'RC43243',
            'description'       =>  'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis 
                                    sunt nobis sequi ullam fugiat voluptas commodi voluptatem animi laboriosam 
                                    doloribus? Consequuntur, beatae provident? Minus inventore et totam in aliquid nobis!',
            
            ],
        ];
        
        Application::insert($application);
    }
}