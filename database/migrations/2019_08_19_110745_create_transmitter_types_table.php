<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransmitterTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transmitter_types', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('name');
            $table->string('label')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
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
        Schema::drop('transmitter_types');
    }
}
