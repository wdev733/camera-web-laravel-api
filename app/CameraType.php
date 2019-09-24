<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CameraType extends Model
{
    public function cameraProfile()
    {
        return $this->belongsTo('App\CameraProfile');
    }
}
