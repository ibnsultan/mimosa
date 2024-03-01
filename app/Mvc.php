<?php

namespace App;

use App\Router;
use Jenssegers\Blade\Blade;
use React\Http\Message\Response;

/**
 * -----------------------------------------------------------------------
 * Class MVC
 * -----------------------------------------------------------------------
 * This class is responsible for handling all basic operations of the 
 * application, such as rendering views, router, exception handling, etc.
 * 
 */

class MVC{

    public $response;

    public function __construct()
    {
        $this->response = new Response();
    }


    public function view($view, $data = [])
    {
        $blade = new Blade('app/Views', 'app/Cache');
        exit($blade->make($view, $data)); 
    }

    public function getRouter()
    {
        return new Router();
    }

}