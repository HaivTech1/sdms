<?php

return [
    'twitter' => [
        'handle' => env('TWITTER_HANDLE'),
    ],
    'comments' => [
        'max'   => env('MAX_LEVEL_COMMENTS'),
    ],
    'replies' => [
        'max'   => env('MAX_REPLIES_TO_COMMENT'),
    ],
    'date_format'         => 'Y-m-d',
    'time_format'         => 'H:i:s',
    'lesson_time_format'  => 'H:i',
    'primary_language'    => 'en',
    'available_languages' => [
        'en' => 'English',
    ],
    'calendar' => [
        'start_time'    => '08:00',
        'end_time'      => '18:00',
    ],
];
