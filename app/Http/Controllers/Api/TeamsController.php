<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Team;
use App\User;
use App\TeamRole;
use Illuminate\Http\Request;
use App\Repository\TeamRepository;
use Mpociot\Teamwork\Facades\Teamwork;

class TeamsController extends Controller
{
    private $repository;
    public function __construct()
    {
        $this->repository = new TeamRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = auth('api')->user();
        $teams = User::with('teams')->find($user->id);
        $response_teams = [];
        foreach ($teams->teams as $team) {
            $response_team = [];
            $response_team['id'] = $team->id;
            $response_team['name'] = $team->name;
            $response_team['slug'] = $team->slug;

            $role = TeamRole::find($team->role->team_role_id);
            $response_team['role'] = $role;

            if ($team->id === $user->current_team_id) {
                $response_team['current_team'] = true;
            } else {
                $response_team['current_team'] = false;
            }
            array_push($response_teams, $response_team);
        }
        return response()->json($response_teams, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $team_creation = $this->repository->createTeam($request, auth('api')->id());
        return response()->json($team_creation, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        if (! auth('api')->user()->isAdminOfTeam($id)) {
            return ['response'=>['message'=>'You must be an admin of this team to view the team details.'], 'status'=>403];
        }

        $check = auth('api')->user()->teams->where('id', $id)->first();
        if ($check) {
            $team = Team::with(['users', 'invites'])->find($id);
            return response()->json($team, 200);
        }

        return response()->json(['message' => "You are not a member of this team so you cannot get it's details"], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $team_update = $this->repository->updateTeam($request, auth('api')->user());
        return response()->json($team_update['response'], $team_update['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Team $team)
    {
        $team_delete = $this->repository->deleteTeam($team, auth('api')->user());
        return response()->json($team_delete['response'], $team_delete['status']);
    }

    public function removeUserFromTeam(User $user)
    {
        $remove_user_from_team = $this->repository->removeUserFromTeam($user, auth('api')->user());
        return response()->json($remove_user_from_team['response'], $remove_user_from_team['status']);
    }

    public function switchUserTeam($team_id)
    {
        $user_switch_team = $this->repository->switchUserTeam($team_id, auth('api')->user());
        return response()->json($user_switch_team['response'], $user_switch_team['status']);
    }

    public function changeUserRole(Request $request, User $user)
    {
        $user_change_role = $this->repository->changeUserRole($user, $request, auth('api')->user());
        return response()->json($user_change_role['response'], $user_change_role['status']);
    }

    public function inviteUserToTeam($email)
    {
        $invite_to_team = $this->repository->inviteUserToTeam($email, auth('api')->user());
        return response()->json($invite_to_team['response'], $invite_to_team['status']);
    }

    public function resendInvitationToUser($invite_id)
    {
        $resend_invitation = $this->repository->resendInvitationToUser($invite_id);
        return response()->json($resend_invitation['response'], $resend_invitation['status']);
    }

    public function destroyInvitation($invite_id)
    {
        $destroy_invitation = $this->repository->destroyInvitation($invite_id);
        return response()->json($destroy_invitation['response'], $destroy_invitation['status']);
    }

    public function teamInvites($id)
    {
        $team_invites = $this->repository->teamInvites($id);
        return response()->json($team_invites['response'], $team_invites['status']);
    }

    public function acceptInviteToTeam($token)
    {
        // Check if the invite exists in the invites table
        $invite = Teamwork::getInviteFromAcceptToken($token);
        if (! $invite) {
            abort(404);
        }

        $user = User::where('email', $invite->email)->first();

        // Check if they already have a user account

        if (! $user) {

            // If they don't have an account, send them to the register page with the token
            $query_params = '?team-accept-token=' . $invite->accept_token;
            $query_params .= '&email=' . $invite->email;
            $link = config('teamwork.register_page_url') . $query_params;

            return redirect($link);
        }

        // We can't do this because it expects them to be authenticated, and we have no session
        // Teamwork::acceptInvite($invite);
        // Instead, we can do it manually...

        $user->attachTeam($invite->team);
        $invite->delete();

        // Team join success page
        return redirect(config('teamwork.success_page_url'));
    }
}
