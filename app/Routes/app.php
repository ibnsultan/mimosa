<?php
define( 'viewPath', getcwd() . '/app/views' );
/*
|--------------------------------------------------------------------------
| Set up 404 handler
|--------------------------------------------------------------------------
| This is default 404 handler, but you can create your own
| 404 handler by modify the code below. The implementation
| you set here will be called when a 404 error is encountered
|
*/
app->set404(function() {
    response()->page(viewPath . '/Errors/404.html', 404);
});

/*
|--------------------------------------------------------------------------
| Set up Controller namespace
|--------------------------------------------------------------------------
| This allows you to directly use controller names instead of typing
| the controller namespace first.
|
*/
app->setNamespace('\App\Controllers');

/*
|--------------------------------------------------------------------------
| Your application routes
|--------------------------------------------------------------------------
| Mimosa automatically loads all files in the routes folder
|
| If you want to manually load routes, you can
| create a file that doesn't start with "_" and manually require
| it here like so:
|
*/
# require __DIR__ . 'dir/custom-route.php';
