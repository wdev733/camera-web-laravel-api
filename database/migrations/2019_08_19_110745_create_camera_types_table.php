<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCameraTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camera_types', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('name');
            $table->string('label')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->bigInteger('camera_profile_id')->unsigned()->nullable()->index('camera_types_camera_profile_id_foreign');
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
        Schema::drop('camera_types');
    }
}
