<?php
namespace App\Models;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';

    public function __construct()
    {
        $this->createTableIfNotExists();
    }

    public function createTableIfNotExists()
    {
        if (!DB::schema()->hasTable($this->table)) {
            DB::schema()->create($this->table, function (Blueprint $table) {
                
                // user table structure

            });
        }
    }

    

}
