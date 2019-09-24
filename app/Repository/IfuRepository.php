<?php

namespace App\Repository;

use App\Ifu;
use App\Site;

class IfuRepository
{
    public function getUsersIfuById($id)
    {
        $ifu = Ifu::belongsToTeam()
            ->where('id', $id)
            ->with('ifuType')
            ->first();
        return $ifu;
    }

    public function updateIfu($request, $ifu_id)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to update devices in this team.'], 'status'=>403];
        }
        $ifu = $this->getUsersIfuById($ifu_id);
        if (! $ifu) {
            return ['response'=>['message'=>'This IFU does not belong to your team.'], 'status'=>403];
        }
        $request->validate([
            'site_id' => 'required|integer',
            'location' => 'string|nullable',
        ]);
        $ifu = Ifu::findOrFail($ifu_id);
        $site = Site::findOrFail($request->site_id);
        if ($site->team_id != $ifu->team_id) {
            return ['response'=>['message'=>'This site belongs to another team.'], 'status'=>403];
        }
        $ifu->site_id = $request->site_id;
        $ifu->location = $request->location;
        $ifu->save();
        return ['response'=>$ifu, 'status'=>200];
    }

    public function disassociateIfu($id)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to update devices in this team.'], 'status'=>403];
        }
        $ifu = $this->getUsersIfuById($id);
        if ($ifu) {
            $ifu->site_id = null;
            $ifu->team_id = null;
            $ifu->save();
            return ['response'=>['message'=>'IFU successfully disassociated.'], 'status'=>200];
        }
        return ['response'=>['message'=>'This IFU does not belong to one of your teams.'], 'status'=>403];
    }
}
