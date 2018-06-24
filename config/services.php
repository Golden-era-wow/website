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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'skyfire' => [
        'location' => env('SF_SOAP_LOCATION', 'http://127.0.0.1:7878'),
        'uri' => env('SF_SOAP_URI', 'urn:TC'),
        'style' => env('SF_SOAP_STYLE', SOAP_RPC),

        'login' => env('SF_USER', 'admin'),
        'password' => env('SF_PASS', 'admin')
    ],

    'algolia' => [
        'app_id' => env('ALGOLIA_APP_ID', ''),
        'search_key' => env('ALGOLIA_SEARCH', ''),
        'admin_key' => env('ALGOLIA_SECRET', '')
    ]
];
