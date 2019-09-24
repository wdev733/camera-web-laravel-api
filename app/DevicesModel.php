<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevicesModel extends Model
{
    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function scopeBelongsToTeam($query, $team = false)
    {
        if (! $team) {
            $team = auth('api')->user()->current_team_id;
        }
        return $query->where('team_id', $team);
    }

    public function scopeWithoutTeam($query)
    {
        return $query->where('team_id', 0)
            ->orWhere('team_id', null);
    }

    public function scopeBelongsToSite($query, $site)
    {
        return $query->whereHas('Site', function ($q) use ($site) {
            $q->where('site_id', $site);
        });
    }
}
