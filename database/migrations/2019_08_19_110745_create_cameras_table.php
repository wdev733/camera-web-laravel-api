<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCamerasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cameras', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('camera_type_id')->unsigned()->index('cameras_camera_type_id_foreign');
            $table->bigInteger('ifu_id')->unsigned()->nullable()->index('cameras_ifu_id_foreign');
            $table->bigInteger('team_id')->unsigned()->nullable()->index('cameras_team_id_foreign');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('location', 65535)->nullable();
            $table->string('pin');
            $table->bigInteger('site_id')->unsigned()->nullable()->index('cameras_site_id_foreign');
            $table->string('camera_username')->nullable();
            $table->string('camera_password')->nullable();
            $table->string('license_key')->nullable();
            $table->bigInteger('assembly_id')->unsigned()->nullable()->index('cameras_assembly_id_foreign');
            $table->string('mac', 17);
            $table->string('stream_to_record')->nullable();
            $table->bigInteger('recording_profile_id')->unsigned()->nullable()->index('cameras_recording_profile_id_foreign');
            $table->string('post_record_frames')->nullable();
            $table->string('pre_record_frames')->nullable();
            $table->string('motion_sensitivity')->nullable();
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
        Schema::drop('cameras');
    }
}
