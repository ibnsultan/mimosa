<?php

/**
 * --------------------------------------------------------------------------
 * Application Configuration
 * --------------------------------------------------------------------------
 * 
 * Path: configs/app.php
 * Author: Abdulbasit Rubeiyya
 * Last Updated: 8 March 2024
 * 
 * This file is used to define the configurations for the application.
 * 
 */

return (object)[


    /*
    |--------------------------------------------------------------------------
    | Global Environment Variables
    |--------------------------------------------------------------------------
    |
    | These are the global environment variables for the application, accessible
    | through the env() | $_ENV | $_SERVER superglobals.
    |
    */

    'app_name' => env('APP_NAME', 'Mimosa'),
    'app_key' => env('APP_KEY', 'hash32:'.bin2hex(random_bytes(32))),
    'app_env' => env('APP_ENV', 'development'),
    'app_debug' => env('APP_DEBUG', true),
    'app_url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    |
    | These are the database configurations for the application.
    |
    */

    'db_driver' => env('DB_DRIVER', 'mysql'),
    'db_host' => env('DB_HOST', 'localhost'),
    'db_name' => env('DB_NAME', 'test'),
    'db_user' => env('DB_USER', 'root'),
    'db_pass' => env('DB_PASS', ''),
    'db_charset' => env('DB_CHARSET', 'utf8'),
    'db_prefix' => env('DB_PREFIX', ''),
    'db_port' => env('DB_PORT', 3306),

    /*
    |--------------------------------------------------------------------------
    | AutoLoaded JS Modules Configuration
    |--------------------------------------------------------------------------
    |
    | These are the configurations for the auto-loaded JS modules in the application.
    |
    */

    'modules' => (object)[
        'path' => '/assets/modules/',
        'reference' => require_once 'modules.php'
    ],


    'viewsDirectory' => getcwd() . '/app/views/',

    /*
    |--------------------------------------------------------------------------
    | Auth Configuration
    |--------------------------------------------------------------------------
    |
    | These are the configurations for the authentication in the application.
    |
    */

    'auth' => require_once 'auth.php',
];