<?php

namespace App\Http\Resources;

use App\Team;
use Illuminate\Http\Resources\Json\JsonResource;

class IfuPermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $team =  Team::find($this->team_id);
        $user = auth('api')->user();
        return [

            'id' => $this->id,
            'vpn_ip' => $this->vpn_ip,
            'secret_key' => $this->secret_key,
            'is_admin' => $user->isAdminOfTeam($this->team_id),
            'is_owner' => $user->isOwnerOfTeam($team->id),
            'cameras' => new CamerasPermissionCollection($this->whenLoaded('cameras')),
        ];
    }
}
