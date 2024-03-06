<?php

namespace App\Console;

class Helpers
{
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