<?php

namespace App\Console\Commands;

use App\UserCameraPermission;
use Illuminate\Console\Command;

class DeleteUserPermissionsForCamera extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete user permissions for camera';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user_camera_permissions = UserCameraPermission::
            with('User.Teams')
            ->with('Camera')
            ->get();
        foreach ($user_camera_permissions as $user_camera_permission) {
            foreach ($user_camera_permission->user->teams as $user_team) {
                if ($user_team->id == $user_camera_permission->camera->team_id) {
                    continue 2;
                }
            }
            $user_camera_permission->delete();
        }
    }
}
