<?php

namespace App\Http\Resources;

use App\Ifu;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IfuPermissionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collection->transform(function (Ifu $ifu) {
            return (new IfuPermissionResource($ifu));
        });
        return parent::toArray($request);
    }
}
