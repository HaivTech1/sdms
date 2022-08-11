<?php

namespace App;

use App\Models\Application;

class NullApplication extends Application
{
    protected $attributes = [
        'name' => 'Champion G',
        'alias'=> 'CL',
        'email'=> 'championGent@gmail.com',
        'line1'=> '09066100815',
        'line2'=> '09066100815',
        'image'=> 'applications/championG.png',
        'slogan'=> 'Default slogan',
        'motto'=> 'Default motto',
        'whatsapp'=> 'Default whatsapp',
        'facebook'=> 'Default facebook',
        'instagram'=> 'Default instagram',
        'address'=> 'Default address',
        'regNo'=> 'RC45466',
        'description'=> 'Default descrption',
    ];
}