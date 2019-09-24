<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CameraPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('camera_permissions')->truncate();

        DB::table('camera_permissions')->insert([
            ['name' => 'can_view', 'default_value' => true],
            ['name' => 'can_view_recordings', 'default_value' => true],
            ['name' => 'can_ptz', 'default_value' => true],
            ['name' => 'can_preset', 'default_value' => true],
            ['name' => 'can_edit_preset', 'default_value' => true],
        ]);
    }
}
