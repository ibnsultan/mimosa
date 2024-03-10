<?php

/*
|--------------------------------------------------------------------------
| Switch to root path
|--------------------------------------------------------------------------
| Point to the application root directory so leaf can accurately
| resolve app paths.
|
*/
chdir(dirname(__DIR__));

/*
|--------------------------------------------------------------------------
| Load the Composer Autoloader
|--------------------------------------------------------------------------
| Composer provides a convenient, automatically generated class loader for
| our application. We'll require it into the script here so that we
| don't have to worry about the loading of any our classes "manually".
|
*/
require 'vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Load the Environment File
|--------------------------------------------------------------------------
| Quickly load the environment file into the application
|
*/
Dotenv\Dotenv::createImmutable(getcwd())->safeLoad();

/*
|--------------------------------------------------------------------------
| Exeptions and Error Handling
|--------------------------------------------------------------------------
| Initialize the Whoops error handler. This will allow us to see a detailed
| error message when an error occurs in the application.
|
 */
(new \Whoops\Run)->pushHandler(new \Whoops\Handler\PrettyPageHandler)->register();

/*
|--------------------------------------------------------------------------
| Initialize the Database
|--------------------------------------------------------------------------
| This class is responsible for initializing the database connection. It
| is required for all apps that use a database. The database connection
| is initialized using the Illuminate\Database\Capsule\Manager class.
| and then shut down when the application is finished.
|
*/
define('DB', (App\Lib\Database::default()) ?? null);

/*
|--------------------------------------------------------------------------
| Load Functions
|--------------------------------------------------------------------------
| This file is responsible for loading all the functions in the app/Functions.php
| file. This is the first step in the application bootstrapping process, and it
| is required for all apps.
|
*/
require_once 'app/lib/Functions.php';

/*
|--------------------------------------------------------------------------
| Create a Routing Instance
|--------------------------------------------------------------------------
| Define a new instance of the Leaf router and assign it to the constant "app".
| This instance will be used to define all the routes for the application.
| 
*/
define('app', (new class extends Leaf\Router {}) ?? null);

/*
|--------------------------------------------------------------------------
| Routing Guard
|--------------------------------------------------------------------------
|
| This class is responsible for checking if the request is authorized to access
| a route.
|
*/
(new \App\Lib\RouteAccess)->authorized();

/*
|--------------------------------------------------------------------------
| Load routing files
|--------------------------------------------------------------------------
| This section is responsible for loading all the routing files in the app/routes
| directory. The loading is done recursively, so all files in subdirectories
| will be loaded as well.
|
*/
load_dir_files('app/routes');

/*
|--------------------------------------------------------------------------
| Initialize the app
|--------------------------------------------------------------------------
| This run method brings in all your routes and starts your application
|
*/
app->run();