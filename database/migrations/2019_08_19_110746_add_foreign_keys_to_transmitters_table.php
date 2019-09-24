<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTransmittersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transmitters', function (Blueprint $table) {
            $table->foreign('assembly_id')->references('id')->on('assemblies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('ifu_id')->references('id')->on('ifus')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('site_id')->references('id')->on('sites')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('transmitter_type_id')->references('id')->on('transmitter_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transmitters', function (Blueprint $table) {
            $table->dropForeign('transmitters_assembly_id_foreign');
            $table->dropForeign('transmitters_ifu_id_foreign');
            $table->dropForeign('transmitters_site_id_foreign');
            $table->dropForeign('transmitters_team_id_foreign');
            $table->dropForeign('transmitters_transmitter_type_id_foreign');
        });
    }
}
