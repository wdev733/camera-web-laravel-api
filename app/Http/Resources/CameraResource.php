<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CameraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $camera = parent::toArray($request);

        unset($camera['camera_username']);
        unset($camera['camera_password']);

        if (! $camera['permissions']['can_view']) {
            unset($camera['pin']);
        }

        return  $camera;
    }
}
