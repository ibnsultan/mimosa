<?php

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

        $model = $this->value;
        $modelFile = getcwd().'/app/models/'.$model.'.php';

        if (file_exists($modelFile)) {
            $this->write("$this->color_red      Error:$this->color_reset The model already exists!");
            return;
        }

        $table = strtolower($model);

        // Get the fillable and hidden columns
        $fillable = $this->getFillables();
        $hidden = $this->getHidden();

        // Get the table structure
        $tableStructure = "\n\t\t\t\t// Your Table structure\n\n";
        
        $schemaStructures = require_once getcwd() . '/configs/database/structure/'. env('DB_DRIVER') .'.php';

        if (DB::schema()->hasTable($table)) {
            $tableStructure = '';
            $columns = DB->getConnection()->select("DESCRIBE $table");
            foreach ($columns as $column) {
                $tableStructure .= "\t\t\t\t\$table->" . $this->getColumnDefinition($table, $column, $schemaStructures) . ";" . PHP_EOL;
            }
        }

        // TODO: I know this part here is scary 😂, will refine it
        // Generate the model content
        $content = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Schema\Blueprint;\nuse Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Capsule\Manager as DB;\n\n";
        $content .= "class $model extends Model\n{\n";
        $content .= "\tprotected \$table = '$table';\n\n";
        $content .= "$fillable\n";
        $content .= "$hidden\n\n";
        $content .= "\tpublic function __construct()\n\t{\n";
        $content .= "\t\t\$this->up();\n";
        $content .= "\t}\n\n";
        $content .= "\tpublic function up()\n\t{\n";
        $content .= "\t\tif (!DB::schema()->hasTable(\$this->table)) {\n";
        $content .= "\t\t\tDB::schema()->create('$table', function (Blueprint \$table) {\n";
        $content .= $tableStructure;
        $content .= "\t\t\t});\n";
        $content .= "\t\t}\n";
        $content .= "\t}\n";
        $content .= "\n\tpublic function down()\n\t{\n";
        $content .= "\t\tif (DB::schema()->hasTable(\$this->table)) {\n";
        $content .= "\t\t\tDB::schema()->dropIfExists(\$this->table);\n";
        $content .= "\t\t}\n";
        $content .= "\t}\n";
        $content .= "}\n";
        
        
        // Write the model file
        file_put_contents($modelFile, $content);
        
        $this->write(
            '',
            $this->color_green."Success: $this->color_reset The model $model has been created successfully!"
        );
    }

    protected function getColumnDefinition(string $table, $column, $schemaStructures) :string
    {

        $columnType = $column->Type;
        $maxLength = null;
        $defaultValue = null;
        
        ($column->Null == 'YES') ? $isNullable = '->nullable()' : $isNullable = null;


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

            $columnType = $schemaStructures[$columnType]['type'];

            return  "$columnType('$column->Field'$maxLength){$defaultValue}$isNullable";
            
        }
        
        return  "$columnType('$column->Field'$maxLength){$defaultValue}$isNullable";
        
    }

    protected function getFillables() :string
    {
        $data = $this->prompt("Enter the fillable columns (comma separated)");

        ($data) ? $fillables = json_encode(explode(',', $data)) : $fillables = '[]';

        return "\tprotected \$fillable = $fillables;";        

    }

    protected function getHidden() :string
    {
        $data = $this->prompt("Enter the hidden columns (comma separated)");

        ($data) ? $hidden = json_encode(explode(',', $data)) : $hidden = '[]';

        return "\tprotected \$hidden = $hidden;";        
    }

    public function deleteModel() :void
    {
        $this->write($this->color_blue. "Deleting the model... $this->color_reset");

        $model = $this->value;
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

