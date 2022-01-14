<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->text('profile_pic')->nullable();
            $table->string('status')->default('administrator');
            
            $table->timestamp('created_at')->useCurrent();
            if (env("DB_CONNECTION")=="pgsql"){
                $table->timestamp('updated_at')->default(DB::raw("'now'::timestamp"));
            }else{
                $table->timestamp('updated_at')->default(DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));
            }
        });
        if (env("DB_CONNECTION") == "pgsql") {
            DB::statement(DB::raw("CREATE TRIGGER admins_updated_at_modtime BEFORE UPDATE ON admins FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();"));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
