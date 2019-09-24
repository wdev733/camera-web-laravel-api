<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordingProfilesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recording_profiles', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->enum('motion_video_action', ['disable','store_locally','store_locally_cache_remotely','store_on_cloud'])->default('disable');
            $table->enum('non_motion_video_action', ['disable','store_locally','store_locally_cache_remotely','store_on_cloud'])->default('disable');
            $table->string('motion_recording_retention_time')->nullable();
            $table->string('non_motion_recording_retention_time')->nullable();
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
        Schema::drop('recording_profiles');
    }
}
