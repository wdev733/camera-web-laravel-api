<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateForeignKeysToAssembliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assemblies', function (Blueprint $table) {
            $table->dropForeign('assemblies_site_id_foreign');
            $table->dropForeign('assemblies_team_id_foreign');
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
        Schema::table('assemblies', function (Blueprint $table) {
            $table->dropForeign('assemblies_site_id_foreign');
            $table->dropForeign('assemblies_team_id_foreign');
            $table->foreign('site_id')->references('id')->on('sites')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('team_id')->references('id')->on('teams')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }
}
