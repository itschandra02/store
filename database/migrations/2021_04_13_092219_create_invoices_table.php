<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('invoices');
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigInteger('invoice_number')->primary();
            $table->string('payment_ref')->nullable();
            $table->bigInteger('user', false, true)->nullable();
            $table->bigInteger('number')->nullable();
            $table->integer('product_data_id');
            $table->string('product_data_name');
            $table->integer('product_id');
            $table->string('product_name');
            $table->bigInteger('price');
            $table->integer('fee')->default(0);
            $table->integer('rates')->default(1);
            $table->integer('discount')->default(0);
            $table->string('type_data')->nullable();
            $table->text('user_input');
            $table->string('payment_method');
            $table->string('status');

            // $table->foreign('user')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('created_at')->useCurrent();
        });
        Schema::table('invoices', function ($table) {
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
        Schema::dropIfExists('invoices');
    }
}
