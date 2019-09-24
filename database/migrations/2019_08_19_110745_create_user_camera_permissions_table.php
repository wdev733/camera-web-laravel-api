<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserCameraPermissionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_camera_permissions', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->index('user_camera_permissions_user_id_foreign');
            $table->bigInteger('camera_id')->unsigned()->index('user_camera_permissions_camera_id_foreign');
            $table->bigInteger('permission_id')->unsigned()->index('user_camera_permissions_permission_id_foreign');
            $table->boolean('accessed');
            $table->timestamps();
            $table->bigInteger('id', true)->unsigned();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_camera_permissions');
    }
}
