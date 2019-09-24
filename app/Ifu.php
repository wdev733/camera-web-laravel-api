<?php

namespace App;

use App\Observers\IfuObserver;

class Ifu extends DevicesModel
{
    public function assembly()
    {
        return $this->belongsTo('App\Assembly');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function cameras()
    {
        return $this->hasMany('App\Camera');
    }

    public function transmitters()
    {
        return $this->hasMany('App\Transmitter');
    }

    public function ifuType()
    {
        return $this->belongsTo('App\IfuType');
    }

    public static function boot()
    {
        parent::boot();

        Ifu::observe(IfuObserver::class);
    }
}
