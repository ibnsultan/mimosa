<?php

namespace App\Console;

class Engine extends \App\Console\Helpers
{    
    public function __construct()
    {
        parent::__construct();
    }

    public function run() :void
    {

        switch ($this->command) {
            case 'key': $this->key(); break;
            case 'init': $this->init(); break;
            case 'serve': $this->serve(); break;
            case 'model': $this->model(); break;
            case 'screen': $this->screen(); break;
            case 'controller': $this->controller(); break;
            default: $this->showHelp();
        }

    }

    public function init() :void
    {
        $this->write("Initializing the application...");
        $this->write("Creating the .env file...");

        $envFile = '.env';
        if (!file_exists($envFile)) {
            copy('.env.example', '.env');
        }

        $this->write("Generating application key...");
        $this->generateKey();

        $this->write("Application initialized successfully!");
    }

    public function key() :void
    {
        // Implement the logic for the "key" command
        switch ($this->option) {
            case 'show': $this->showKey(); break;
            case 'generate': $this->generateKey(); break;
            default: $this->helpKey(); break;
        }
    }

    protected function showKey() :void
    {
        $key = env('APP_KEY');
        $this->write("Your application key is: ", "\t".$this->color_green.$key.$this->color_reset);
    }

    protected function generateKey() :void
    {
        // generate a new key with random bytes
        $key = "hash32:".bin2hex(random_bytes(32));
        $this->updateConfig('APP_KEY', $key);

        $this->write("Your new application key is: ", "\t".$this->color_green.$key.$this->color_reset);
    }

    protected function helpKey()
    {
        $this->write(
            $this->color_blue . "Mimosa - Key Guideline" . $this->color_reset,
            "Usage:",
            "   key:help",
            "   key:show",
            "   key:generate"
        );
    }

    protected function serve() :void
    {
        $this->write(
            $this->color_blue . "Mimosa - Serve" . $this->color_reset,
            "    Starting the development server at http://localhost:3000",
            "    Press $this->color_red Ctrl+C $this->color_reset to stop the server"
        );

        shell_exec('php -S localhost:3000 -t public');
    }

    public function model() :void
    {
        // Implement the logic for the "model" command
        switch ($this->option) {
            case 'list': $this->listClasses('/app/models', 'Models'); break;
            case 'create': (new \App\Console\Model)->createModel(); break;
            case 'delete': (new \App\Console\Model)->deleteModel(); break;
            default: $this->helpModel(); break;
        }
    }

    protected function helpModel() :void
    {
        $this->write(
            $this->color_blue . "Mimosa - Model Guideline" . $this->color_reset,
            "Usage:",
            "   model:list",
            "   model:create [name]",
            "   model:delete [name]"
        );
    }

    public function controller() :void
    {
        // Implement the logic for the "controller" command
        switch ($this->option) {
            case 'list': $this->listClasses('/app/controllers', 'controllers'); break;
            case 'create': $this->createController(); break;
            case 'delete': $this->deleteController(); break;
            default: $this->helpController(); break;
        }
    }

    protected function createController(): void
    {
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

        $content = "<?php\n\nnamespace App\Controllers;\n\nclass $controller extends \\App\\Controller\n{\n\tpublic function __construct()\n\t{\n\t\tparent::__construct();\n\t}\n}";

        file_put_contents($controllerFile, $content);
        $this->write(
            $this->color_green . "Success: $this->color_reset",
            "      The controller $controller has been created successfully!"
        );
    }


    protected function deleteController() :void
    {
        $controller = $this->value;
        $controllerFile = getcwd().'/app/controllers/'.$controller.'.php';

        $this->write($this->color_blue. "Deleting the controller... $this->color_reset");

        if (!file_exists($controllerFile)) {
            $this->write(
                $this->color_red . "Error: $this->color_reset",
                "      The controller does not exist!"
            );
            return;
        }

        unlink($controllerFile);
        $this->write(
            $this->color_green . "Success: $this->color_reset",
            "      The controller $controller has been deleted successfully!"
        );
    }

    protected function helpController() :void
    {
        $this->write(
            $this->color_blue . "Mimosa - Controller Guideline" . $this->color_reset,
            "Usage:",
            "   controller:list",
            "   controller:create [name]",
            "   controller:delete [name]"
        );
    }

    protected function screen() :void
    {
        switch ($this->option) {
            case 'list': ''; break;
            case 'create': (new \App\Console\Screen)->createScreen(); break;
            case 'delete': (new \App\Console\Screen)->deleteScreen(); break;
            default: (new \App\Console\Screen)->helpScreen(); break;
        }
    }

    protected function listClasses($path, $type) :void
    {
        $classes = array_diff(scandir(getcwd().$path), ['.', '..']);
        $this->write($this->color_green . "$type Registered: $this->color_reset ");
        
        foreach ($classes as $class) {
            $this->write("$this->color_blue  $class $this->color_reset \t\t $path/$class");
        }
    }

    protected function showHelp() :void
    {

        $this->write(
            "$this->color_green",
            "Mimosa Cli Console $this->color_reset",
            "Usage: php console [command] [option]",
            "Commands:",
            "  make:controller [name]  Create a new controller",
            "  make:model [name]       Create a new model",
            "  make:migration [name]   Create a new migration",
            "  make:seed [name]        Create a new seed"
        );

    }

}