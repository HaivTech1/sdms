<?php

namespace App;

use App\Models\Banner;

class NullBanner extends Banner
{
    protected $attributes = [
        'title' => 'Haiv Technology Support Limited',
        'sub_title'=> 'welcome to',
        'description'=> 'Unique solutions for you',
        'button_text'=> 'Learn more',
        'feature_one_title'=> 'Quality Teachers',
        'feature_two_title'=> 'Best Curriculam',
        'feature_three_title'=> 'Global Recognition',
        'feature_one'=> 'What do you think is better to receive after each lesson a lovely looking.',
        'feature_two'=> 'What do you think is better to receive after each lesson a lovely looking.',
        'feature_three'=> 'What do you think is better to receive after each lesson a lovely looking.',
    ];
}