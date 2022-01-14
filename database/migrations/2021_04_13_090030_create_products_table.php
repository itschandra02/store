<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subtitle');
            $table->text('description');
            $table->text('thumbnail')->nullable();
            $table->string('slug');
            $table->boolean('active')->default(false);
            $table->boolean('use_input')->nullable()->default(false);
            // $table->text('form_input')->nullable();
            $table->timestamp('created_at')->useCurrent();
            if (env("DB_CONNECTION")=="pgsql"){
                $table->timestamp('updated_at')->default(DB::raw("'now'::timestamp"));
            }else{
                $table->timestamp('updated_at')->default(DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));
            }
        });
        if (env("DB_CONNECTION") == "pgsql") {
            DB::statement(DB::raw("CREATE TRIGGER products_updated_at_modtime BEFORE UPDATE ON products FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();"));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
