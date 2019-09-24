<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIfusTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifus', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('license_key')->nullable();
            $table->bigInteger('site_id')->unsigned()->nullable()->index('ifus_site_id_foreign');
            $table->bigInteger('team_id')->unsigned()->nullable()->index('ifus_team_id_foreign');
            $table->bigInteger('assembly_id')->unsigned()->nullable()->index('ifus_assembly_id_foreign');
            $table->string('mac', 17);
            $table->bigInteger('ifu_type_id')->unsigned()->index('ifus_ifu_type_id_foreign');
            $table->string('local_ip', 45)->nullable();
            $table->string('public_ip', 45)->nullable();
            $table->string('api_key')->nullable();
            $table->string('vpn_username')->nullable();
            $table->string('vpn_password')->nullable();
            $table->string('vpn_server')->nullable();
            $table->text('location', 65535)->nullable();
            $table->string('secret_key');
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
        Schema::drop('ifus');
    }
}
