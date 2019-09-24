<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CameraPermission extends Model
{
    protected $table = 'camera_permissions';
    protected $casts = ['default_value' => 'boolean'];
}
