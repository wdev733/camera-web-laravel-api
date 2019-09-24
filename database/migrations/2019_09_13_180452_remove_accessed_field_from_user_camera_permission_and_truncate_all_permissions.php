<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class RemoveAccessedFieldFromUserCameraPermissionAndTruncateAllPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Permissions are now negative, so let's truncate 
        
        //disable foreign key check for this connection before running seeders
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('user_camera_permissions')->truncate();

        Schema::table('user_camera_permissions', function (Blueprint $table) {
            if (Schema::hasColumn('user_camera_permissions', 'accessed')) {
                $table->dropColumn('accessed');
            }
        });

        Artisan::call('db:seed', [
            '--class' => CameraPermissionsTableSeeder::class,
        ]);

		// Enable again
		// DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('user_camera_permissions')->truncate();

        Schema::table('user_camera_permissions', function (Blueprint $table) {
            if (! Schema::hasColumn('user_camera_permissions', 'accessed')) {
                $table->addColumn('boolean', 'accessed');
            }
        });

        // supposed to only apply to a single connection and reset it's self
		// but I like to explicitly undo what I've done for clarity
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
