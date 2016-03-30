<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAmazosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
            Schema::create('damage_types', function(Blueprint $table) {
                $table->increments('id');
                $table->string('name')->length(255)->required();
                $table->string('slug')->length(32)->required();
                $table->string('notes');
                $table->boolean('enabled');

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
        Schema::drop('damage_types');
    }

}
