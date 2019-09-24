<?php

namespace App\Http\Resources;

use App\Camera;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CamerasPermissionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Camera $camera) {
            return (new CamerasPermissionResource($camera));
        });
        return parent::toArray($request);
    }
}
