<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutation', function (Blueprint $table) {
            $table->string("bank");
            $table->date("mutationDate")->nullable();
            $table->string("mutationNote")->nullable();
            $table->string("mutationStatus")->nullable();
            $table->bigInteger("mutationAmount")->nullable();
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
        Schema::dropIfExists('mutation');
    }
}
