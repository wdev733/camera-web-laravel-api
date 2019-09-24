<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransmittersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transmitters', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('license_key');
            $table->bigInteger('transmitter_type_id')->unsigned()->index('transmitters_transmitter_type_id_foreign');
            $table->bigInteger('team_id')->unsigned()->nullable()->index('transmitters_team_id_foreign');
            $table->bigInteger('site_id')->unsigned()->nullable()->index('transmitters_site_id_foreign');
            $table->bigInteger('ifu_id')->unsigned()->nullable()->index('transmitters_ifu_id_foreign');
            $table->string('mode');
            $table->string('ssid');
            $table->string('password');
            $table->bigInteger('assembly_id')->unsigned()->nullable()->index('transmitters_assembly_id_foreign');
            $table->string('mac', 17);
            $table->string('local_ip', 45)->nullable();
            $table->text('location', 65535)->nullable();
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
        Schema::drop('transmitters');
    }
}
