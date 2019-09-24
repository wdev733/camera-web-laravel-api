<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCameraPermission extends Model
{
    protected $table = 'user_camera_permissions';

    public function cameraPermissions()
    {
        return $this->belongsTo('App\CameraPermission', 'permission_id', 'id')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function camera()
    {
        return $this->belongsTo('App\Camera', 'camera_id', 'id');
    }
}
