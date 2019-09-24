<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateForeignKeysToCamerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cameras', function (Blueprint $table) {
            $table->dropForeign('cameras_site_id_foreign');
            $table->dropForeign('cameras_team_id_foreign');
            $table->dropForeign('cameras_ifu_id_foreign');
            $table->foreign('ifu_id')->references('id')->on('ifus')->onUpdate('RESTRICT')->onDelete('set null');
            $table->foreign('site_id')->references('id')->on('sites')->onUpdate('RESTRICT')->onDelete('set null');
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('RESTRICT')->onDelete('set null');
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
            $table->dropForeign('cameras_site_id_foreign');
            $table->dropForeign('cameras_team_id_foreign');
            $table->dropForeign('cameras_ifu_id_foreign');
            $table->foreign('site_id')->references('id')->on('sites')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('ifu_id')->references('id')->on('ifus')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
}
