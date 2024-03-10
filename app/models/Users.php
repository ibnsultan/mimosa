<?php

namespace App\Models;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class Users extends Model
{
    protected $table = 'users';

    protected $hidden = ["password","remember_token"];
    protected $fillable = ["fullname","email","role","avatar","email_verified","password","remember_token"];

    protected $casts = [
	    'created_at'=> 'timestamp',
	    'updated_at'=> 'timestamp'
	];

    public function __construct()
    {
        $this->up();
    }

    public function up()
    {
        if (!DB::schema()->hasTable($this->table)) {
            DB::schema()->create($this->table, function (Blueprint $table) {
                
				// TODO: Warning - please review the structure of the table if matches your table structure
				$table->bigIncrements('id', 20);
				$table->string('fullname', 255);
				$table->string('email', 255)->unique();
				$table->char('role', 50)->default('subscriber');
				$table->text('avatar')->nullable();
				$table->timestamp('email_verified_at')->nullable();
				$table->string('password', 255);
				$table->string('remember_token', 255)->nullable();
				$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
				$table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            });
        }
    }

    public function down()
    {
        if (DB::schema()->hasTable($this->table)) {
            DB::schema()->dropIfExists($this->table);
        }
    }
}
