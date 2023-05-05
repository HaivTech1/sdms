<?php

namespace App;

use App\Models\Application;

class NullApplication extends Application
{
    protected $attributes = [
        'name'      =>  'St. Louis Nursery and Primary School, Ondo',
        'alias'     =>  'St. Louis',
        'email'     =>  'contact@st.louisNPSO.com.ng',
        'line1'        =>  '08032426364',
        'line2'        =>  '08032426364',
        'image'      =>  'applications/haivtech.png',
        'address'       =>  'Kilometer 2, Ife road, Valentino, Ondo State',
        'motto'     =>  'Ut-Snt-Unum - Dieu le veux',
        'slogan'        =>  'Ut-Snt-Unum - Dieu le veux',
        'regNo'        =>  'RC2004222',
        'description'       =>  'Ut-Snt-Unum - Dieu le veux',
        'facebook'        =>  'St.Loius Nursery/Primary, Ondo',
        'instagram'        =>  'Haivtech',
        'twitter'        =>  'Haivtech',
        'linkedin'        =>  'Haivtech',
        'website'        =>  'https://www.st.louisNPSO.com.ng',
        'period_time' => 30
    ];
}