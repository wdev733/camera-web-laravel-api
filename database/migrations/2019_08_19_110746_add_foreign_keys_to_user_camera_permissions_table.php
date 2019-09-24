<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUserCameraPermissionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_camera_permissions', function (Blueprint $table) {
            $table->foreign('camera_id')->references('id')->on('cameras')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('permission_id')->references('id')->on('camera_permissions')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_camera_permissions', function (Blueprint $table) {
            $table->dropForeign('user_camera_permissions_camera_id_foreign');
            $table->dropForeign('user_camera_permissions_permission_id_foreign');
            $table->dropForeign('user_camera_permissions_user_id_foreign');
        });
    }
}
