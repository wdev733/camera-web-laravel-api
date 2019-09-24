<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamUserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->index('team_user_user_id_foreign');
            $table->bigInteger('team_id')->unsigned()->index('team_user_team_id_foreign');
            $table->timestamps();
            $table->integer('team_role_id')->unsigned()->default(3);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('team_user');
    }
}
