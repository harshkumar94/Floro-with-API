<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->text('address');
            $table->text('house_number');
            $table->text('postal_code');
            $table->text('city');
            $table->text('telephone_number');
            $table->boolean('is_active')->default(0);
            $table->rememberToken();
            $table->timestamps();

            // $table->bigIncrements('id');
            // $table->string('username');
            // $table->string('email')->unique();
            // $table->string('password');
            // $table->string('first_name');
            // $table->string('last_name');
            // $table->string('address');
            // $table->integer('house_number');
            // $table->integer('postal_code');
            // $table->string('city');
            // $table->bigInteger('telephone_number');
            // // $table->timestamp('email_verified_at')->nullable();
            // $table->boolean('active')->default('1');
            // $table->rememberToken();
            // $table->timestamps();
        });
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
