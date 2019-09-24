<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCamerasTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cameras', function (Blueprint $table) {
            $table->foreign('assembly_id')->references('id')->on('assemblies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('camera_type_id')->references('id')->on('camera_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('ifu_id')->references('id')->on('ifus')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('recording_profile_id')->references('id')->on('recording_profiles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('site_id')->references('id')->on('sites')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cameras', function (Blueprint $table) {
            $table->dropForeign('cameras_assembly_id_foreign');
            $table->dropForeign('cameras_camera_type_id_foreign');
            $table->dropForeign('cameras_ifu_id_foreign');
            $table->dropForeign('cameras_recording_profile_id_foreign');
            $table->dropForeign('cameras_site_id_foreign');
            $table->dropForeign('cameras_team_id_foreign');
        });
    }
}
