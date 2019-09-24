<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPtzPresetsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ptz_presets', function (Blueprint $table) {
            $table->foreign('camera_id')->references('id')->on('cameras')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ptz_presets', function (Blueprint $table) {
            $table->dropForeign('ptz_presets_camera_id_foreign');
        });
    }
}
