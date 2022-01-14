<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaygateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paygate', function (Blueprint $table) {
            // currently support bca, qris/bukukas
            $table->string("payment");
            $table->string("norek")->nullable(); // banking
            $table->string("name")->nullable();
            $table->string("username")->nullable(); // for bca
            $table->string("password")->nullable(); // for bca
            $table->string("token")->nullable(); // for bukukas
            $table->string("image")->nullable();
            $table->boolean("status")->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paygate');
    }
}
