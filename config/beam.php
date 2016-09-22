<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Beam Defaults
    |--------------------------------------------------------------------------
    */
   
   'enable_activations' => true,

   'login_after_registration' => true,

   'redirect_when_unactive' => '/home',

   'notification_message' => \Beam\Foundation\Notifications\AccountActivation::class,

    'defaults' => [
        'activations' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Account Activations
    |--------------------------------------------------------------------------
    */

    'activations' => [
        'users' => [
            'provider' => 'users',
            'table' => 'account_activations',
            'expire' => 60,
        ],
    ],

];
