<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */


    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),         // Your Facebook Client ID
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'), // Your Facebook Client Secret
        'redirect' => '/authorise/facebook',
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),         // Your Facebook Client ID
        'client_secret' => env('TWITTER_CLIENT_SECRET'), // Your Facebook Client Secret
        'redirect' => '/authorise/twitter',
    ],
];
