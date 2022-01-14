<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableTempForgot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_forgot', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('token')->unique();
            $table->string('number')->nullable();
            $table->string('description')->nullable();
            $table->boolean('status')->default(true);
            // $table->timestamps();
        });

        Schema::table('temp_forgot', function ($table) {
            if (env("DB_CONNECTION") == "pgsql") {
                $table->timestamp('expired_at')->default(DB::raw("(current_timestamp + '1 days'::INTERVAL)"));
            } else {
                $table->timestamp('expired_at')->default(DB::raw('(current_timestamp() + interval 1 day)'));
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_forgot');
    }
}
