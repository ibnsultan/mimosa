<?php

namespace App\Lib;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public static function Initialize()
    {
        
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => env('DB_DRIVER', 'mysql'),
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_NAME', 'test'),
            'username'  => env('DB_USER', 'root'),
            'password'  => env('DB_PASS', ''),
            'charset'   => env('DB_CHARSET', 'utf8'),
            'collation' => 'utf8_unicode_ci',
            'prefix'    => env('DB_PREFIX', ''),
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public static function Close()
    {
        Capsule::disconnect();
    }
}