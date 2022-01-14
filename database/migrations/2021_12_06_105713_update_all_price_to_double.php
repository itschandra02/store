<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAllPriceToDouble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
            $table->decimal('price')->change();
            $table->decimal('fee')->change();
            $table->decimal("coin")->nullable();
            DB::statement("ALTER TABLE invoices CHANGE `expired_at` `expired_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
        });
        Schema::table('product_data', function (Blueprint $table) {
            $table->decimal('price')->change();
            $table->decimal("coin_used")->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('balance')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
        });
    }
}
