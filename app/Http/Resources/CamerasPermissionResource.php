<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CamerasPermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = auth('api')->user();
        return [
            'id' => $this->id,
            'permissions' => [
                'can_view' =>  $user->hasNegativeCameraPermission(1, $this->id),
                'can_view_recordings' => $user->hasNegativeCameraPermission(2, $this->id),
                'can_ptz' => $user->hasNegativeCameraPermission(3, $this->id),
                'can_preset' => $user->hasNegativeCameraPermission(4, $this->id),
                'can_edit_preset' => $user->hasNegativeCameraPermission(5, $this->id),

            ],
        ];
    }
}
