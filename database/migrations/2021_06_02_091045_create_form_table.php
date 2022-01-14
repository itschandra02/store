<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_inputs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id', false, true);
            $table->string('name');
            $table->string('value');
            $table->string('type')->default('text'); //text, number, password,
            $table->string('placeholder')->default('');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            if (env("DB_CONNECTION")=="pgsql"){
                $table->timestamp('updated_at')->default(DB::raw("'now'::timestamp"));
            }else{
                $table->timestamp('updated_at')->default(DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));
            }
        });
        if (env("DB_CONNECTION") == "pgsql") {
            DB::statement(DB::raw("CREATE TRIGGER form_inputs_updated_at_modtime BEFORE UPDATE ON form_inputs FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();"));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_inputs');
    }
}
