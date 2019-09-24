<?php

namespace App;

use Mpociot\Teamwork\TeamworkTeam;

class Team extends TeamworkTeam
{
    protected $fillable = ['name', 'slug'];

    public function ifus()
    {
        return $this->hasMany('App\Ifu');
    }

    public function assemblies()
    {
        return $this->hasMany('App\Assembly');
    }

    public function cameras()
    {
        return $this->hasMany('App\Camera');
    }

    public function transmitters()
    {
        return $this->hasMany('App\Transmitter');
    }

    public function sites()
    {
        return $this->hasMany('App\Site');
    }

    public function views()
    {
        return $this->hasMany('App\View');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user')
            ->using(TeamRole::class)
            ->as('role')
            ->withPivot('team_role_id');
    }

    public function owner()
    {
        return $this->hasOneThrough(User::class, TeamUser::class, 'team_id', 'id', 'id', 'user_id')->where('team_role_id', 1);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            self::generateSlug($model);
            unset($model->owner);
        });

        self::updating(function ($model) {
            self::generateSlug($model);
            unset($model->owner);
        });
    }
    public static function generateSlug($model)
    {
        $slug = strtolower($model->name);
        $slug = preg_replace('/[^a-zA-Z0-9 -]/', '', $slug);
        $model->slug = str_replace(' ', '-', $slug);
    }
}
