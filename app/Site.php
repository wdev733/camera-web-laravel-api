<?php

namespace App;

class Site extends DevicesModel
{
    public function ifus()
    {
        return $this->hasMany('App\Ifu');
    }
}
