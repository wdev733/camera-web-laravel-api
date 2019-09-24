<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIfusTableModifyIpAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ifus', function (Blueprint $table) {
            $table->dropColumn('local_ip');
            $table->dropColumn('public_ip');
            $table->dropColumn('vpn_username');
            $table->ipAddress('vpn_ip')->nullable();
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
            $table->string('local_ip', 45)->nullable();
            $table->string('public_ip', 45)->nullable();
            $table->string('vpn_username')->nullable();
            $table->dropColumn('vpn_ip');
        });
    }
}
