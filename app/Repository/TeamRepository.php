<?php

namespace App\Repository;

use App\Team;
use App\User;
use App\TeamUser;
use Illuminate\Support\Facades\Mail;
use Mpociot\Teamwork\Exceptions\UserNotInTeamException;
use Mpociot\Teamwork\Facades\Teamwork;
use Mpociot\Teamwork\TeamInvite;

class TeamRepository
{
    public function createTeam($request, $user_id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams',
        ]);
        $team = new Team;
        $team->name = $request->name;
        $team->save();

        $team_user = new TeamUser;
        $team_user->team_id = $team->id;
        $team_user->user_id = $user_id;
        $team_user->team_role_id = \Config::get('teamrole.default_owner_role');
        $team_user->save();

        // Check if user has a current team set, if he doesn't set the new team as his current team.
        $user = User::find($user_id);
        if (! $user->currentTeam) {
            $user->switchTeam($team->id);
        }

        return $team;
    }

    public function updateTeam($request, $user)
    {
        $request->validate([
            'name' => 'required|string|unique:teams,name,'.$user->current_team_id,
        ]);
        if ($user->isAdminOfCurrentTeam()) {
            $team = Team::find($user->current_team_id);
            $team->name = $request->name;
            $team->save();
            return ['response'=>$team, 'status'=>200];
        }

        return ['response'=>['message'=>'You are not allowed to update this team.'], 'status'=>403];
    }

    public function deleteTeam($team, $user)
    {
        if ($user->isOwnerOfTeam($team->id)) {
            try {
                $team->delete();
            } catch (\Exception $exception) {
                return ['response'=>['message'=>'You cannot delete a team when there are still devices attached to it.'], 'status'=>403];
            }
            return ['response'=>['message'=>'Team successfully deleted.'], 'status'=>200];
        }
        return ['response'=>['message'=>'You must be the owner of a team to delete it.'], 'status'=>403];
    }

    public function removeUserFromTeam($user, $auth_user)
    {
        // Check if the logged in user is an admin
        if (! $auth_user->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You do not have permission to delete the user from the team.'], 'status'=>403];
        }

        // Check if user is an owner
        if ($user->isOwnerOfTeam($auth_user->current_team_id)) {
            return ['response'=>['message'=>'You cannot remove the owner from the team.'], 'status'=>403];
        }

        $user->detachTeam($auth_user->current_team_id);
        return ['response'=>['message'=>'User successfully removed from team.'], 'status'=>200];
    }

    public function switchUserTeam($team_id, $user)
    {
        try {
            $user->switchTeam($team_id);
        } catch (UserNotInTeamException $e) {
            return ['response'=>['message'=>'Unable to switch current team.'], 'status'=>403];
        }
        return ['response'=>['message'=>'Current team successfully switched.'], 'status'=>200];
    }

    public function changeUserRole($user, $request, $auth_user)
    {
        $request->validate([
            'role' => 'required',
        ]);
        // Check if they are trying to change the owner
        if (! in_array($request->role, [2,3]) || $user->isOwnerOfTeam($auth_user->current_team_id)) {
            return ['response'=>['message'=>'You are not allowed to change the owner of a team.'], 'status'=>403];
        }

        // Check if the user is a member of the team
        if (! $user->teams->where('id', $auth_user->current_team_id)->first()) {
            return ['response'=>['message'=>'User is not member of this team.'], 'status'=>403];
        }

        // Check if they are an admin
        if (! $auth_user->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to change role in this team.'], 'status'=>403];
        }

        // Finally try and update the role
        try {
            $user->updateTeamRole($request->role, $auth_user->current_team_id);
        } catch (\Exception $exception) {
            return ['response'=>['message'=>'There was an error changing the user\'s role'], 'status'=>400];
        }
        return ['response'=>['message'=>'User role successfully changed.'], 'status'=>200];
    }

    public function inviteUserToTeam($email, $auth_user)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to invite users to this team.'], 'status'=>403];
        }


        $team = Team::findOrFail($auth_user->current_team_id);
        $invited_user = User::where('email', $email)->first();

        if ($invited_user && $team->hasUser($invited_user)) {
            return ['response'=>['message'=>'User is already a member of this team.'], 'status'=>403];
        }

        if (Teamwork::hasPendingInvite($email, $team)) {
            return ['response'=>['message'=>'User already invited to team.'], 'status'=>403];
        }

        Teamwork::inviteToTeam($email, $team, function ($invite) {
            Mail::send('teamwork.emails.invite', ['team' => $invite->team, 'invite' => $invite], function ($m) use ($invite) {
                $m->to($invite->email)->subject('Invitation to join team '.$invite->team->name);
            });
        });
        return ['response'=>['message'=>'User successfully invited to team.'], 'status'=>200];
    }

    public function resendInvitationToUser($invite_id)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to resend invites for this team.'], 'status'=>403];
        }

        $invite = TeamInvite::findOrFail($invite_id);

        if ($invite->team_id !== auth('api')->user()->current_team_id) {
            return ['response'=>['message'=>'This invite does not belong to your team'], 'status'=>403];
        }

        $invite = TeamInvite::findOrFail($invite_id);
        Mail::send('teamwork.emails.invite', ['team' => $invite->team, 'invite' => $invite], function ($m) use ($invite) {
            $m->to($invite->email)->subject('Invitation to join team '.$invite->team->name);
        });

        return ['response'=>['message'=>'User successfully invited to team.'], 'status'=>200];
    }

    public function destroyInvitation($invite_id)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to cancel invites for this team.'], 'status'=>403];
        }

        $invite = TeamInvite::findOrFail($invite_id);

        if ($invite->team_id !== auth('api')->user()->current_team_id) {
            return ['response'=>['message'=>'This invite does not belong to your team'], 'status'=>403];
        }

        $invite->delete();

        return ['response'=>['message'=>'Invite successfully deleted'], 'status'=>200];
    }

    public function teamInvites($id)
    {
        if (auth('api')->user()->isAdminOfTeam($id)) {
            $team = Team::find($id)->invites;
            return ['response'=>$team, 'status'=>200];
        }
        return ['response'=>['message'=>'You are not allowed to see invites for this team.'], 'status'=>403];
    }
}
