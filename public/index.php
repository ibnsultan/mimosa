<?php

/*
|--------------------------------------------------------------------------
| Application Entry Point
|--------------------------------------------------------------------------
| This file is the entry point for the application. It is responsible for
| loading the Composer autoloader, loading the environment file, and
| requiring the routes file.
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
| The environment file is responsible for loading any environment variables
| that are required by the application. This is the first step in the
| application bootstrapping process, and it is required for all apps.
|
 */
Dotenv\Dotenv::createImmutable(getcwd())->safeLoad();

/*
|--------------------------------------------------------------------------
| Exeptions and Error Handling
|--------------------------------------------------------------------------
| This file is responsible for setting up the error handling for the
| application. This includes the handling of any exceptions that are
| thrown by the application, as well as the handling of any errors.
|
 */
(new \Whoops\Run)->pushHandler(new \Whoops\Handler\PrettyPageHandler)->register();

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
| This file is responsible for creating a new instance of the Leaf\Router
| class. This instance will be used to load the application routes.
| 
*/
define('app', (new class extends Leaf\Router {}) ?? null);


/*
|--------------------------------------------------------------------------
| Load routing files
|--------------------------------------------------------------------------
| This file is responsible for loading all the routes in the app/routes
| directory and subdirectories.
*/
load_dir_files('app/routes');

/*
|--------------------------------------------------------------------------
| Initialize the app
|--------------------------------------------------------------------------
| This file is responsible for initializing the application.
| 
*/
app->run();