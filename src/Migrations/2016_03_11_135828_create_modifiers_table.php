<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amazo_mods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->default('1')->required();
            $table->integer('damage_type_id')->unsigned()->default('1')->required();
            $table->decimal('amount',14,4)->default('1')->required();
            $table->enum('mod_type', ['*', '+'])->default('*');

            $table->foreign('parent_id')->references('id')->on('damage_types')->onDelete('cascade');
            $table->foreign('damage_type_id')->references('id')->on('damage_types')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('amazo_mods');
    }
}
