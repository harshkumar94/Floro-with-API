<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('field_name');
            $table->string('old_value');
            $table->string('modified_value');
            $table->string('modified_by');
            $table->timestamps();


            // $table->uuid('id');
            // $table->string('entity_type')->comment('polymorphic relations (models, i.e. users table)');
            // $table->uuid('entity_id')->comment('entity model reference id.');
            // $table->string('column_name')->comment('field name which is modified.');
            // $table->text('old_value');
            // $table->text('modified_value');
            // $table->uuid('modified_by')->comment('reference to user model');
            // $table->timestamps();
            // $table->primary('id');
            // $table->foreign('modified_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_activities');
    }
}
