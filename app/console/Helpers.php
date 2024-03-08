<?php

/**
 * Mimosa - A PHP+reactJS Framework For Web
 * ------------------------------------------------------------------------------------
 * Console Helpers : app/console/Helpers.php
 * ------------------------------------------------------------------------------------
 * 
 * This class is responsible for providing helper methods to the console commands.
 * 
 * Author: Abdulbasit Rubeiyya
 * Last Updated: 8 March 2024
 * 
 * 
 * Class Methods:
 *     - write() :void
 *     - prompt($query) :mixed
 *     - updateConfig($key, $value) :void
 *     
 */

namespace App\Console;

class Helpers
{

    public $color_red = "\033[31m";
    public $color_blue = "\033[34m";
    public $color_green = "\033[32m";
    public $color_yellow = "\033[33m";
    public $color_reset = "\033[0m";

    protected $value;
    protected $option;
    protected $command;

    public function __construct()
    {        
        $this->write('');
        $this->parseArguments();
    }

    
    protected function parseArguments() :void
    {
        
        $arguments = array_slice($_SERVER['argv'], 1);

        $this->value = $arguments[1] ?? null;

        if (count($arguments) >= 1):
            $arguments = explode(':', $arguments[0]);

            $this->command = $arguments[0];
            $this->option = $arguments[1] ?? null;
        
            else: exit( (new \App\Console\Engine)->showHelp() );
            
        endif;
    }

    function write() :void {
        
        $args = func_get_args();
        foreach($args as $arg):
            echo $arg.PHP_EOL;
        endforeach;

    }

    function prompt($query): mixed {

        fwrite(STDOUT, $query . ": ");
        $input = trim(fgets(STDIN));
        return $input;

    }    

    function updateConfig($key, $value) :void
    {
        $envFile = '.env';
        $key = strtoupper($key);

        // Read the existing content
        $currentContent = file_get_contents($envFile);
        $newContent = preg_replace("/$key=.*/", "$key=$value", $currentContent);
        file_put_contents($envFile, $newContent);

    }
}