<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIfusTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ifus', function (Blueprint $table) {
            $table->foreign('assembly_id')->references('id')->on('assemblies')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('ifu_type_id')->references('id')->on('ifu_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
        Schema::table('ifus', function (Blueprint $table) {
            $table->dropForeign('ifus_assembly_id_foreign');
            $table->dropForeign('ifus_ifu_type_id_foreign');
            $table->dropForeign('ifus_site_id_foreign');
            $table->dropForeign('ifus_team_id_foreign');
        });
    }
}
