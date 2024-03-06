<?php

namespace App\Console;

use Illuminate\Database\Capsule\Manager as Capsule;

class Engine extends \App\Console\Helpers
{    
    protected $value;
    protected $option;
    protected $command;

    protected $helpers;

    public $color_red = "\033[31m";
    public $color_blue = "\033[34m";
    public $color_green = "\033[32m";
    public $color_yellow = "\033[33m";
    public $color_reset = "\033[0m";

    public function __construct()
    {        
        $this->write('');
        $this->parseArguments();
    }

    public function run() :void
    {

        switch ($this->command) {
            case 'key': $this->key(); break;
            case 'init': $this->init(); break;
            case 'serve': $this->serve(); break;
            case 'model': $this->model(); break;
            case 'controller': $this->controller(); break;
            case 'migration': $this->migration(); break;
            default: $this->showHelp();
        }

    }

    protected function parseArguments() :void
    {
        
        $arguments = array_slice($_SERVER['argv'], 1);

        $this->value = $arguments[1] ?? null;

        if (count($arguments) >= 1):
            $arguments = explode(':', $arguments[0]);

            $this->command = $arguments[0];
            $this->option = $arguments[1] ?? null;
        
            else: exit( $this->showHelp() );
            
        endif;
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
            case 'create': $this->createModel(); break;
            case 'delete': $this->deleteModel(); break;
            default: $this->helpModel(); break;
        }
    }

    protected function createModel(): void
    {
        $model = $this->value;
        $modelFile = getcwd().'/app/models/'.$model.'.php';

        if (file_exists($modelFile)) {
            $this->write("The model already exists!");
            return;
        }

        $table = strtolower($model);

        // Get the table structure
        $tableStructure = '';
        
        // TODO: Generate the table structure for Table creation
        /*
        $schemaStructures = require_once getcwd() . '/configs/database/structure/'. env('DB_DRIVER') .'.php';

        if (Capsule::schema()->hasTable($table)) {
            $columns = Capsule::schema()->getColumnListing($table);
            foreach ($columns as $column) {
                $tableStructure .= "\t\t\t\t\$table->" . $this->getColumnDefinition($table, $column, $schemaStructures) . ";" . PHP_EOL;
            }
        }*/

        // Generate the model content
        $content = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Capsule\Manager as Capsule;\nuse Illuminate\Database\Schema\Blueprint;\n\nuse Illuminate\Database\Eloquent\Model;\n\n";
        $content .= "class $model extends Model\n{\n";
        $content .= "\tprotected \$table = '$table';\n\n";
        $content .= "\tpublic function __construct()\n\t{\n";
        $content .= "\t\t\$this->createTableIfNotExists();\n";
        $content .= "\t}\n\n";
        $content .= "\tpublic function createTableIfNotExists()\n\t{\n";
        $content .= "\t\tif (!Capsule::schema()->hasTable(\$this->table)) {\n";
        $content .= "\t\t\tCapsule::schema()->create('$table', function (Blueprint \$table) {\n\n\n";
        $content .= "\t\t\t\t// Write your table structure here\n\n\n";
        // $content .= $tableStructure; ref TODO:
        $content .= "\t\t\t});\n";
        $content .= "\t\t}\n";
        $content .= "\t}\n}";
        
        // Write the model file
        file_put_contents($modelFile, $content);
        
        $this->write("The model $model has been created successfully!");
    }

    protected function getColumnDefinition(string $table, string $column, $schemaStructures): string
    {
        $columnType = Capsule::schema()->getColumnType($table, $column);

        // die(var_dump($schemaStructures));

        if (array_key_exists($columnType, $schemaStructures)) {
            $response = $schemaStructures[$columnType]['type'];

            if(isset($schemaStructures[$columnType]['length'])) :

                $response .= "('$column', ".$schemaStructures[$columnType]['length'].")";
                else: $response .= "('$column')";

            endif;

            return "$response";
        }

        return "\t\t\tcolumnType('$column')";
        
    }


    protected function deleteModel() :void
    {
        $model = $this->value;
        $modelFile = getcwd().'/app/models/'.$model.'.php';

        if (!file_exists($modelFile)) {
            $this->write("The model does not exist!");
            return;
        }

        unlink($modelFile);
        $this->write("The model $model has been deleted successfully!");
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

    protected function listClasses($path, $type) :void
    {
        $classes = array_diff(scandir(getcwd().$path), ['.', '..']);
        $this->write($this->color_green . "$type Registered: $this->color_reset ");
        
        foreach ($classes as $class) {
            $this->write("$this->color_blue  $class $this->color_reset \t\t $path/$class");
        }
    }

    protected function migration() :void
    {
        switch ($this->option) {
            case 'list': $this->listClasses('/app/migrations', 'Migrations'); break;
            case 'create': $this->createMigration(); break;
            //case 'run': $this->runMigration(); break;
            default: $this->helpModel(); break;
        }
    }

    protected function createMigration() :void
    {
        /*$migration = $this->value;
        $migrationFile = getcwd().'/app/migrations/'.date('Y_m_d_His').'_'.$migration.'.php';

        if (file_exists($migrationFile)) {
            $this->write("The migration already exists!");
            return;
        }

        $content = "<?php\n\nuse Phinx\Migration\AbstractMigration;\n\nclass $migration extends AbstractMigration\n{\n\tpublic function change()\n\t{\n\t\t// Write your migration here\n\t}\n}";

        file_put_contents($migrationFile, $content);
        $this->write("The migration $migration has been created successfully!");*/

        shell_exec("php vendor/bin/phinx create $this->value -c configs/phinx.php");
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