<?php

namespace App;

use App\Observers\AssemblyObserver;

class Assembly extends DevicesModel
{
    public function assemblyType()
    {
        return $this->belongsTo('App\AssemblyType');
    }

    public function site()
    {
        return $this->belongsTo('App\Site');
    }

    public static function boot()
    {
        parent::boot();

        Assembly::observe(AssemblyObserver::class);
    }
}
