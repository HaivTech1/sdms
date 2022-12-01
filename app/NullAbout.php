<?php

namespace App;

use App\Models\About;

class NullAbout extends About
{
    protected $attributes = [
        'title' => 'Haiv Technology Support Limited',
        'description_one'=> 'welcome to',
        'description_two'=> 'Unique solutions for you',
    ];
}