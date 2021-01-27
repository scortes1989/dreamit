<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccessResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'date'      => $this->created_at ? $this->created_at->format('d/m/Y H:i') : null,
            'user'      => new UserResource($this->whenLoaded('user')),
            'building'  => new BuildingResource($this->whenLoaded('building')),
        ];
    }
}
