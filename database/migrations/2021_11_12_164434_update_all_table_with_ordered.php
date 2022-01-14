<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAllTableWithOrdered extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->integer('ordered')->default(0);
        });
        Schema::table('products', function (Blueprint $table) {
            $table->integer('ordered')->default(0);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->integer('ordered')->default(0);
        });
        Schema::table('carousels', function (Blueprint $table) {
            $table->integer('ordered')->default(0);
        });
        Schema::table('product_data', function (Blueprint $table) {
            $table->integer('ordered')->default(0);
        });
        Schema::table('form_inputs', function (Blueprint $table) {
            $table->integer('ordered')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
