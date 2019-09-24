<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckHasCurrentTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()) {
            // Check if user has a current team set
            if (! $request->user()->currentTeam) {
                // Check if user is a member of any teams
                if ($request->user()->teams->isNotEmpty()) {
                    // If user is a member of a team, set it as his current team
                    auth('api')->user()->switchTeam($request->user()->teams->first());
                } else {
                    // If user is not a member of a team return error message.
                    return response()->json(['message' => 'The user must be a member of a team.'], 460);
                }
            }
        }
        return $next($request);
    }
}
