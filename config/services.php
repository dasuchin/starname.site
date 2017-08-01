<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '395995519315-5q13gi80j7bnpqlbp9sfdgv9g3hm700c.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', 'aUP9LChVTQrOs2A8PvIiisOF'),
        'redirect' => env('GOOGLE_REDIRECT', 'http://starname.dev/auth/google/callback')
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', '1230461456983652'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', '9316717945439d7eb40edef3ba0b19b9'),
        'redirect' => env('FACEBOOK_REDIRECT', 'http://starname.dev/auth/facebook/callback')
    ]

];
