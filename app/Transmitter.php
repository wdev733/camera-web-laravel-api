<?php

namespace App;

use App\Observers\TransmitterObserver;

class Transmitter extends DevicesModel
{
    public function assembly()
    {
        return $this->belongsTo('App\Assembly');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public function transmitterType()
    {
        return $this->belongsTo('App\TransmitterType');
    }

    public function ifu()
    {
        return $this->belongsTo('App\Ifu');
    }

    public static function boot()
    {
        parent::boot();

        Transmitter::observe(TransmitterObserver::class);
    }
}
