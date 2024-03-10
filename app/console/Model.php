<?php

/**
 * Mimosa - A PHP+reactJS Framework For Web
 * ------------------------------------------------------------------------------------
 * Model Generator : app/console/Model.php
 * ------------------------------------------------------------------------------------
 * 
 * This class is responsible for generating and managing the models in your application.
 * 
 * Author: Abdulbasit Rubeiyya
 * Last Updated: 8 March 2024
 * 
 * 
 * Class Methods:
 *      - createModel() :void
 *      - deleteModel() :void
 *      - getColumnDefinition(string $table, $column, $schemaStructures) :string
 *      - getFillables() :string
 *      - getHidden() :string
 *      - getCasts() :string
 * 
 */

namespace App\Console;

use Illuminate\Database\Capsule\Manager as DB;

class Model extends \App\Console\Helpers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createModel(): void
    {
        $this->write($this->color_blue."Creating the model... ".$this->color_reset);

        $model = ucfirst($this->value ?? $this->prompt("Enter the model name"));
        ($model == '') ? exit : null;

        $modelFile = getcwd().'/app/models/'.$model.'.php';

        if (file_exists($modelFile)) {
            $this->write("$this->color_red      Error:$this->color_reset The model already exists!");
            return;
        }

        $table = strtolower($model);

        // Get the fillable and hidden columns
        $fillable = $this->getFillables();
        $hidden = $this->getHidden();

        $casts = $this->getCasts();

        // Get the table structure
        $tableStructure = "// Your Table structure here ...";
        
        $schemaStructures = require_once getcwd() . '/config/database/structure/'. env('DB_DRIVER') .'.php';

        if (DB::schema()->hasTable($table)) {
            $tableStructure = "\n\t\t\t\t// TODO: Warning - please review the structure of the table if matches your table structure\n";
            $columns = DB->getConnection()->select("DESCRIBE $table");
            foreach ($columns as $column) {
                $tableStructure .= "\t\t\t\t\$table->" . $this->getColumnDefinition($table, $column, $schemaStructures) . ";" . PHP_EOL;
            }
        }

        $content =<<<DATA
        <?php

        namespace App\Models;

        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Eloquent\Model;
        use Illuminate\Database\Capsule\Manager as DB;

        class $model extends Model
        {
            protected \$table = '$table';

            $hidden
            $fillable

            $casts

            public function __construct()
            {
                \$this->up();
            }

            public function up()
            {
                if (!DB::schema()->hasTable(\$this->table)) {
                    DB::schema()->create(\$this->table, function (Blueprint \$table) {
                        $tableStructure
                    });
                }
            }

            public function down()
            {
                if (DB::schema()->hasTable(\$this->table)) {
                    DB::schema()->dropIfExists(\$this->table);
                }
            }
        }

        DATA;
        
        
        // Write the model file
        file_put_contents($modelFile, $content);
        
        $this->write(
            '',
            $this->color_green."Success: $this->color_reset The model $model has been created successfully!"
        );
    }

    protected function getColumnDefinition(string $table, $column, $schemaStructures) :string
    {

        // die(var_dump($column));

        $columnType = $column->Type;
        $maxLength = null;
        $defaultValue = null;
        
        ($column->Null == 'YES') ? $isNullable = '->nullable()' : $isNullable = null;

        // determine if column is primary or unique
        $keyType = null;
        if($column->Key == 'PRI' and strpos($column->Extra, 'auto_increment') == false) {
            $keyType = '->primary()';
        }elseif($column->Key == 'UNI') {
            $keyType = '->unique()';
        }

        if(count(explode(' ', $column->Type)) > 1) {
            $columnType = $column->Type = explode(' ', $column->Type)[0];
        }

        // determine if columnType has length is enum
        if(substr($columnType, -1) == ')') {
            $columnType = substr($column->Type, 0, strpos($column->Type, '('));
            $maxLength = ', ';
            $maxLength .= substr($column->Type, strpos($column->Type, '('), strpos($column->Type, ')'));

            ($columnType == 'enum') ?
                $maxLength = str_replace(['(', ')'], ['[', ']'], $maxLength) :
                $maxLength = str_replace(['(', ')'], ['', ''], $maxLength);
        }

        // determine if column has default value
        if ($column->Default) {

            try{
                if(DB->getConnection()->select("SELECT $column->Default")){
                    $defaultValue = "->default(DB::raw('$column->Default'))";
                }
            } catch (\Throwable $th) {
                
                if (is_string($column->Default)) {
                    $defaultValue = '->default(\'' . $column->Default . '\')';
                } else {
                    $defaultValue = '->default(' . $column->Default . ')';
                }

            }

        }
        

        if (array_key_exists($columnType, $schemaStructures)) {

            // check if columnType has autoincrement
            if ($column->Extra == 'auto_increment') {
                $columnType = $schemaStructures[$columnType]['onIncrement'];
            }else{
                $columnType = $schemaStructures[$columnType]['type'];
            }

            return  "$columnType('$column->Field'$maxLength){$defaultValue}{$keyType}$isNullable";
            
        }
        
        return  "$columnType('$column->Field'$maxLength){$defaultValue}{$keyType}$isNullable";
        
    }

    protected function getFillables() :string
    {
        $data = $this->prompt("Enter the fillable columns (comma separated)");

        ($data) ? $fillables = json_encode(array_map('trim', explode(',', $data))) : $fillables = '[]';

        return "protected \$fillable = $fillables;";        

    }

    protected function getHidden() :string
    {
        $data = $this->prompt("Enter the hidden columns (comma separated)");

        ($data) ? $hidden = json_encode(array_map('trim', explode(',', $data))) : $hidden = '[]';

        return "protected \$hidden = $hidden;";        
    }

    protected function getCasts() :string
    {
        $this->write("Enter the casts (comma separated)");
        $data = $this->prompt("\t Example: id:integer, email:string");

        // ($data) ? $casts = json_encode(explode(',', $data), JSON_PRETTY_PRINT) : $casts = '[]';
        ($data) ? $casts = explode(',', $data) : $casts = '[]';

        if(is_array($casts) and count($casts) > 0) {
            $casts = array_map(function($cast){
                $cast = explode(':', $cast);
                return "'$cast[0]' => '$cast[1]'";
            }, $casts);
        }

        (is_array($casts)) ? json_encode($casts, JSON_PRETTY_PRINT) : $casts = '[]';

        // sanitize the casts
        $casts = str_replace(
            ["\n" , "\"'", "'\""],
            ["\n\t", "'", "'"],
            $casts
        );

        // TODO: Reveiw what causes the extra white space
        $casts = str_replace("' ", "'", $casts);
        
        return "protected \$casts = $casts;";
    }

    public function deleteModel() :void
    {
        $this->write($this->color_blue. "Deleting the model... $this->color_reset");

        $model = $this->value ?? $this->prompt("Enter the model name");
        ($model == '') ? exit : null;

        $modelFile = getcwd().'/app/models/'.$model.'.php';

        if (!file_exists($modelFile)) {
            $this->write($this->color_red . "Error: $this->color_reset", "      The model does not exist!");
            return;
        }

        unlink($modelFile);
        $this->write(
            $this->color_green . "Success: $this->color_reset".
            "      The model $model has been deleted successfully!"
        );
    }


}

