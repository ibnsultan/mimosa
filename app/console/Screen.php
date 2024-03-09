<?php

/**
 * Mimosa - A PHP+reactJS Framework For Web
 * ------------------------------------------------------------------------------------
 * Screens Generator : app/console/Model.php
 * ------------------------------------------------------------------------------------
 * 
 * This class is responsible for generating and managing the screens in your application.
 * 
 * Author: Abdulbasit Rubeiyya
 * Last Updated: 8 March 2024
 * 
 * 
 * Class Methods:
 *      - createScreen() :void
 *      - deleteScreen() :void
 *      - helpScreen() :void
 *      - createScreenController() :void
 *      - addScreenRoute() :void
 * 
 */

namespace App\Console;

class Screen extends \App\Console\Helpers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createScreen() :void
    {
        $screen = $this->value;
        $screenName = ucfirst($screen);
        $screenDir = getcwd().'/app/views/'.$screen;

        $this->write($this->color_blue."Creating the screen... ".$this->color_reset);

        (is_dir($screenDir)) ?
            exit($this->color_red."Error:$this->color_reset The screen '$screenName' already exists!\n\n") : 
            mkdir($screenDir, 0777, true);
        
        $componentsPage = <<<DATA
        // Path: app/views/$screenName/Components.blade.jsx

        const $screenName = (props) => {
            return (
                <div>
                    <h1> Welcome to {props.title} </h1>
                </div>
            );
        }

        DATA;

        $mainPage = <<<DATA
        <!-- Path: app/views/$screen/Main.blade.php -->
        @extends('layouts.app')
        @section('jsx')

            <div>
                <$screenName title='{{env('APP_NAME')}}' />
            </div>

        @endsection
        DATA;

        $this->write($this->color_yellow. "Writting: $this->color_reset Components.blade.jsx");
        file_put_contents($screenDir.'/Components.blade.jsx', $componentsPage);

        $this->write($this->color_yellow. "Writting: $this->color_reset Main.blade.php");
        file_put_contents($screenDir.'/Main.blade.php', $mainPage);

        $this->write($this->color_yellow. "Writting: $this->color_reset Stylesheet.blade.jsx");
        file_put_contents($screenDir.'/Stylesheet.blade.jsx', '');

        $this->write($this->color_green. "Success:$this->color_reset The screen $screenName has been created successfully!",'');

        $this->createScreenController();
        $this->addScreenRoute();

    }

    function deleteScreen(){

        $screen = $this->value;
        $this->write($this->color_blue. "Deleting the Screen $screen ... $this->color_reset");

        $screenDir = getcwd().'/app/views/'.$screen;
        if(!is_dir($screenDir)){
            $this->write($this->color_red. "Error:$this->color_reset The screen does not exist!");
            return;
        }

        delete_dir($screenDir);

        $this->write($this->color_green. "Success:$this->color_reset The screen $screen has been deleted successfully!");

    }

    public function helpScreen() :void
    {
        $this->write(
            $this->color_blue . "Mimosa - Screen Management Guide" . $this->color_reset,
            "Usage:",
            "   screen:list",
            "   screen:create [name]",
            "   screen:delete [name]"
        );
    }

    protected function createScreenController(): void
    {
        $data = $this->prompt("Would you like to create a controller for this screen?$this->color_yellow (YES/no)$this->color_reset");

        if(in_array(strtolower($data), ['no', 'n'])) return;

        $controller = ucfirst($this->value);

        if (strtolower(substr($controller, -10)) != 'controller') {
            $controller .= 'Controller';
        }

        $controllerFile = getcwd().'/app/controllers/'.$controller.'.php';

        $this->write($this->color_blue. "Creating the controller... $this->color_reset");

        if (file_exists($controllerFile)) {
            $this->write(
                $this->color_red . "Error: $this->color_reset",
                "     The controller already exists! $this->color_reset"
            );
            return;
        }

        $screenName = ucfirst($this->value);
        $content = <<<DATA
        <?php

        namespace App\Controllers;

        class $controller extends \\App\\Controller
        {
            public function __construct()
            {
                parent::__construct();
            }

            public function index()
            {
                \$data = [ 'title' => '$screenName' ];
                render('$screenName', \$data);
            }
        }

        DATA;

        file_put_contents($controllerFile, $content);

        $this->write($this->color_green. "Success: $this->color_reset The controller $controller has been created successfully!", '');
    }

    protected function addScreenRoute(): void
    {
        $screen = $this->value;
        $data = $this->prompt("Would you like to add a route for this screen?$this->color_yellow (YES/no)$this->color_reset");

        if(in_array(strtolower($data), ['no', 'n'])) return;
        $route = $this->prompt("Enter the route for this screen$this->color_yellow [ /$screen ]$this->color_reset");

        $route = ($route == '') ? "/$screen" : $route;
        $route = strtolower($route);
        file_get_contents(getcwd().'/app/routes/web.php');

        $controller = ucfirst($this->value);

        if (strtolower(substr($controller, -10)) != 'controller') {
            $controller .= 'Controller';
        }

        $content = "\n\napp->get('$route', '$controller@index');";
        file_put_contents(getcwd().'/app/routes/web.php', $content, FILE_APPEND);

        $this->write($this->color_green. "Success:$this->color_reset The route for $screen has been added successfully!");

    }
    

}