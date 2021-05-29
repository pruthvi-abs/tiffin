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
    /*
    'twitter' => [
       'client_id' => 'rArwyeQcKr82HfwXrLJBnoKAL',
       'client_secret' => 'AWMqodEK6KQ76SXOo8gMckN1i215FlWYNbXwadVoUbZaOi9KKr',
       'redirect' => 'https://www.neoinventions.com/dailytiffin/login/twitter/callback',
    ],
    */
    'facebook' => [
       /*
       'client_id' => '1087020308415001',
       'client_secret' => '6f299afe2239e23f544bc442168fcb24',
       */
       'client_id' => '305595994356176',
       'client_secret' => '61af76522bc5cb4ba422ac9279ebb09c',
       'redirect' => 'https://www.neoinventions.com/dailytiffin/userlogin/facebook/callback',
       //https://developers.facebook.com/apps/?show_reminder=true
    ],
    'google' => [
       /*
       'client_id' => '231834096371-1qqvaa7eikop6rcuocmnfrc51d6qmo3r.apps.googleusercontent.com',
       'client_secret' => 'U6r-RhVY1zcH7-ClvZlFw870',
       */
       'client_id' => '264661881861-nmndmq415tu6lth2mr35mkvcjgpdu0rd.apps.googleusercontent.com',
       'client_secret' => 'ZIFNoH5I4wDddsjwQBTNhaiG',
       'redirect' => 'https://www.neoinventions.com/dailytiffin/userlogin/google/callback',
    ],

];
