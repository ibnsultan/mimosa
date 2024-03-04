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

    public function render($view, $data = [])
    {
        $blade = new Blade('app/Views', 'app/Cache');
        $blade->addExtension('blade.jsx', 'blade');

        // check if the view is a directory
        $newDir = getcwd() .'/app/Views/'. str_replace('.', '/', $view);
        
        if (is_dir($newDir)) { $view = $view . '@Main'; }

        if (strpos($view, '@') !== false) :
            $components = explode('@', $view);
            $view = str_replace('@', '.', $view); 
            $data['screenComponents'] = "$components[0].Components";
        endif;

        exit($blade->make($view, $data));
    }


    public function view($view, $data = [])
    {
        $blade = new Blade('app/Views', 'app/Cache');

        // add support for jsx files
        $blade->addExtension('blade.jsx', 'blade');
        exit($blade->make($view, $data)); 
    }

    public function getRouter()
    {
        return new Router();
    }

}