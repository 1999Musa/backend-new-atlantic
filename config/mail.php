<?php

return [


    'default' => env('MAIL_MAILER', 'log'),



    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'mail.arbellafashion.com'),
            'port' => env('MAIL_PORT', 465),
            'encryption' => env('MAIL_ENCRYPTION', 'ssl'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
        ],
    ],


    'from' => [
    'address' => env('MAIL_FROM_ADDRESS', 'no-reply@atlanticfabrics.com'),
    'name' => env('MAIL_FROM_NAME', 'New Atlantic Ltd...'),
],

];
