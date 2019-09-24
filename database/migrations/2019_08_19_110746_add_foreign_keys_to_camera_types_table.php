<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCameraTypesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('camera_types', function (Blueprint $table) {
            $table->foreign('camera_profile_id')->references('id')->on('camera_profiles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('camera_types', function (Blueprint $table) {
            $table->dropForeign('camera_types_camera_profile_id_foreign');
        });
    }
}
