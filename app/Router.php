<?php

namespace App;

use FrameworkX\App;
use Psr\Http\Message\ServerRequestInterface;

class Router 
{

    protected $app;
    protected $routes = [];

    public function __construct()
    {
        $this->app = new App();
    }
    
    /**
     * Add get route to the collection
     * 
     * @param string $route
     * @param string @expression i.e 'HomeController@index' | or a closure
     * @param array $params
     * 
     * @return void
     */
    public function get($route, $expression)
    {
        $this->execute($route, $expression, 'get');
    }

    public function execute($route, $expression, $method)
    {
        if(is_callable($expression)){
            $this->app->$method($route, $expression);
        }else{
            $this->app->$method($route, function (ServerRequestInterface $request) use ($expression) {

                $controller = explode('@', $expression)[0];
                $action = explode('@', $expression)[1];

                $controller = 'App\Controllers\\' . $controller;

                $controller = new $controller();
                return $controller->$action($request);
            });
        }
    }

    public function run()
    {
        $this->app->run();
    }


}