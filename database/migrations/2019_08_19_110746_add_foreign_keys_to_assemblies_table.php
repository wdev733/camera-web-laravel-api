<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAssembliesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assemblies', function (Blueprint $table) {
            $table->foreign('assembly_type_id')->references('id')->on('assembly_types')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
        Schema::table('assemblies', function (Blueprint $table) {
            $table->dropForeign('assemblies_assembly_type_id_foreign');
            $table->dropForeign('assemblies_site_id_foreign');
            $table->dropForeign('assemblies_team_id_foreign');
        });
    }
}
