<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAssembliesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assemblies', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('license_key');
            $table->bigInteger('assembly_type_id')->unsigned()->index('assemblies_assembly_type_id_foreign');
            $table->bigInteger('team_id')->unsigned()->nullable()->index('assemblies_team_id_foreign');
            $table->bigInteger('site_id')->unsigned()->nullable()->index('assemblies_site_id_foreign');
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
        Schema::drop('assemblies');
    }
}
