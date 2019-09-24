<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PtzPreset extends Model
{
    public function camera()
    {
        return $this->belongsTo('App\Camera');
    }
}
