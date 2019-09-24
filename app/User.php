<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mpociot\Teamwork\Traits\UserHasTeams;
use Tehcodedninja\Teamroles\Traits\UsedByUsers;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;
    use UserHasTeams;

    use UsedByUsers {                                                                       // Add these lines starting here
        UsedByUsers::isOwnerOfTeam insteadof UserHasTeams;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'dark_theme' => 'boolean',
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')
            ->using(TeamRole::class)
            ->as('role')
            ->withPivot('team_role_id');
    }
    public function cameras()
    {
        return $this->belongsToMany(CameraPermission::class, 'user_camera_permissions', 'user_id', 'camera_id');
    }
    public function views()
    {
        return $this->hasMany('App\View');
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isAdminOfCurrentTeam()
    {
        if (! is_null($this->getCurrentTeamRoleAttribute()) && in_array($this->getCurrentTeamRoleAttribute()->id, [1,2])) {
            return true;
        }
        return false;
    }

    public function isAdminOfTeam($team_id)
    {
        if (! is_null($this->teamRoleFor($team_id)) && in_array($this->teamRoleFor($team_id)->id, [1,2])) {
            return true;
        }
        return false;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function ownedTeams()
    {
        return $this->teams()->wherePivot('team_role_id', '=', \Config::get('teamrole.default_owner_role'));
    }

    public function isOwner()
    {
        return ($this->teams()->wherePivot('team_role_id', '=', \Config::get('teamrole.default_owner_role'))->first()) ? true : false;
    }

    public function isOwnerOfTeam($team)
    {
        $team_id        = $this->retrieveTeamId($team);
        return ($this->teams()
            ->wherePivot('team_role_id', \Config::get('teamrole.default_owner_role'))
            ->wherePivot('team_id', $team_id)->first()
        ) ? true : false;
    }

    public function userVerified()
    {
        return true;
    }

    public static function boot()
    {
        parent::boot();

        self::updating(function ($model) {
            if (isset($model->verified)) {
                $user = User::find($model->id);
                if (! $user->hasVerifiedEmail() && $model->verified) {
                    $user->markEmailAsVerified();
                } elseif ($user->hasVerifiedEmail() && ! $model->verified) {
                    $model->email_verified_at = null;
                }
                unset($model->verified);
            }
        });
    }
    public function hasNegativeCameraPermission($permissionId, $cameraId)
    {
        return ($this->cameras()->wherePivot('permission_id', '=', $permissionId)->wherePivot('camera_id', $cameraId)->first()) ? false : true;
    }
}
