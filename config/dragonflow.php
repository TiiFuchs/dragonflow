<?php

return [

    'allowed_chats' => [

        397304, // @TiiFuchs
        -1001332711507, // Teamleitung Dragonfighters

    ],

    'member_group' => env('TELEGRAM_NOTIFICATION_TO'),

    'mail_to' => env('MAIL_NOTIFICATION_TO'),

    'pegelonline' => [

        'station' => '66ff3eb4-513b-478b-abd2-2f5126ea66fd', // Frankfurt Osthafen

    ],

    'dwd' => [

        'latitude'  => '50.100850',
        'longitude' => '8.668600',

    ],

    'sportmember' => [

        'username' => env('SPORTMEMBER_USERNAME'),

        'password' => env('SPORTMEMBER_PASSWORD'),

        'team' => 240710, // FKV Dragonfighter

    ],

];
