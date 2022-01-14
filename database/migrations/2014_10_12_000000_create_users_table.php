<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('number');
            $table->string('password');
            $table->integer('balance')->default(0);
            $table->string('status')->default('member');
            $table->timestamp('last_login')->useCurrent();
            $table->timestamp('expire_seller_at')->useCurrent();

            // OAUTH
            $table->string('avatar')->nullable()->default("https://image.flaticon.com/icons/png/512/149/149071.png");
            $table->string('provider', 20)->nullable();
            $table->string('provider_id')->nullable();
            $table->string('access_token')->nullable();
            $table->rememberToken();


            $table->timestamp('created_at')->useCurrent();
            if (env("DB_CONNECTION") == "pgsql") {
                $table->timestamp('updated_at')->default(DB::raw("'now'::timestamp"));
            } else {
                $table->timestamp('updated_at')->default(DB::raw("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"));
            }
        });
        if (env("DB_CONNECTION") == "pgsql") {
            DB::statement(DB::raw("DROP FUNCTION IF EXISTS update_updated_at_column;"));
            DB::statement(DB::raw("CREATE FUNCTION update_updated_at_column() RETURNS trigger
            LANGUAGE plpgsql
            AS $$
        BEGIN
            NEW.updated_at = NOW();
            RETURN NEW;
        END;
        $$;
        "));
            DB::statement(DB::raw("CREATE TRIGGER users_updated_at_modtime BEFORE UPDATE ON users FOR EACH ROW EXECUTE PROCEDURE update_updated_at_column();"));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
