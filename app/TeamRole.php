<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamRole extends Pivot
{
    protected $table = 'team_roles';

    protected $fillable = ['name', 'label'];
}
