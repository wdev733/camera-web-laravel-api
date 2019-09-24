<?php

namespace App;

use App\Observers\CameraObserver;

class Camera extends DevicesModel
{
    public function ifu()
    {
        return $this->belongsTo('App\Ifu');
    }

    public function cameraType()
    {
        return $this->belongsTo('App\CameraType');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function recordingProfile()
    {
        return $this->belongsTo('App\RecordingProfile');
    }

    public function assembly()
    {
        return $this->belongsTo('App\Assembly');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public static function boot()
    {
        parent::boot();

        Camera::observe(CameraObserver::class);
    }
    public function setMacAttribute($value)
    {
        $this->attributes['mac'] = strtoupper($value);
    }
}
