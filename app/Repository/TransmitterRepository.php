<?php

namespace App\Repository;

use App\Site;
use App\Transmitter;

class TransmitterRepository
{
    public function getUsersTransmitterById($id)
    {
        $transmitter = Transmitter::belongsToTeam()
            ->where('id', $id)
            ->with('transmitterType')
            ->first();
        return $transmitter;
    }

    public function updateTransmitter($request, $transmitter_id)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to update devices in this team.'], 'status'=>403];
        }
        $transmitter = $this->getUsersTransmitterById($transmitter_id);
        if (! $transmitter) {
            return ['response'=>['message'=>'This transmitter does not belong to your team.'], 'status'=>403];
        }
        $request->validate([
            'site_id' => 'required|integer',
            'location' => 'string|nullable',
        ]);
        $transmitter = Transmitter::findOrFail($transmitter_id);

        $site = Site::findOrFail($request->site_id);
        if ($site->team_id != $transmitter->team_id) {
            return ['response'=>['message'=>'This site belongs to another team.'], 'status'=>403];
        }
        $transmitter->site_id = $request->site_id;

        $transmitter->location = $request->location;

        $transmitter->save();
        return ['response'=>$transmitter, 'status'=>200];
    }

    public function disassociateTransmitter($id)
    {
        if (! auth('api')->user()->isAdminOfCurrentTeam()) {
            return ['response'=>['message'=>'You are not allowed to update devices in this team.'], 'status'=>403];
        }
        $transmitter = $this->getUsersTransmitterById($id);
        if ($transmitter) {
            $transmitter->site_id = null;
            $transmitter->team_id = null;
            $transmitter->save();
            return ['response'=>['message'=>'Transmitter successfully disassociated.'], 'status'=>200];
        }
        return ['response'=>['message'=>'This transmitter does not belong to one of your teams.'], 'status'=>403];
    }
}
