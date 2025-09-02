<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default RouterOS connection parameters
    |--------------------------------------------------------------------------
    |
    | You may leave these null and supply them at runtime (e.g. via login form).
    | Otherwise they will be used as fallback defaults.
    */

    'host'     => env('ROUTEROS_HOST'),
    'username' => env('ROUTEROS_USERNAME'),
    'password' => env('ROUTEROS_PASSWORD'),
];
