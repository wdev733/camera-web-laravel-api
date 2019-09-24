<?php

namespace App\Repository;

use App\Rules\UniqueSiteNameWithinTeam;
use App\Site;

class SiteRepository
{
    public function getUsersSiteById($id)
    {
        $site = Site::belongsToTeam()
            ->where('id', $id)->first();
        return $site;
    }

    public function updateSite($request, $id)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to update sites in this team.'], 'status'=>403];
        }
        $request->validate([
            'name' => ['required','string',new UniqueSiteNameWithinTeam($id)],
            'location' => 'required|string',
        ]);
        $site = $this->getUsersSiteById($id);
        if (! $site) {
            return ['response'=>['message'=>'Site not found.'], 'status'=>403];
        }
        $site->name = $request->name;
        $site->location = $request->location;
        $site->save();
        return ['response'=>$site, 'status'=>200];
    }

    public function createSite($request)
    {
        $request->validate([
            'name' => ['required','string',new UniqueSiteNameWithinTeam],
            'location' => 'required|string',
        ]);
        $site = new Site;
        $site->name = $request->name;
        $site->location = $request->location;
        $site->team_id = auth('api')->user()->current_team_id;
        $site->save();
        return $site;
    }
}
