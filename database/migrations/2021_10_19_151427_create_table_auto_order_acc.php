<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAutoOrderAcc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_order_acc', function (Blueprint $table) {
            $table->string("account"); // kiosgamer/smile
            $table->string("username")->nullable(); // for kiosgamer. null for smile
            $table->string("password")->nullable(); // for kiosgamer. null for smile
            $table->text("cookie")->nullable(); // for smile, null for kiosgamer
            $table->text("token")->nullable(); // for kiosgamer
            $table->text("otp_key")->nullable(); //for kiosgamer
            $table->boolean('is_active')->default(1);
            $table->integer("product_id")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_order_acc');
    }
}
