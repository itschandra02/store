<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableVoucherData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("product_data_id");
            $table->string("data")->nullable();
            $table->text("description")->nullable();
            $table->string("status")->nullable();
            $table->boolean("used")->default(false);
            $table->string("purchased")->nullable();
            $table->timestamp("purchased_at")->nullable();
            $table->date("expired_at")->nullable();
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("updated_at")->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_data');
    }
}
