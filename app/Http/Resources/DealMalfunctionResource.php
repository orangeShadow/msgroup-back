<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealMalfunctionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return isset($this->id)? [
            'id' => $this->id,
            'title' => $this->title,
            'hours' => $this->hours,
            'price' => $this->price,
            'spares' => SpareResource::collection($this->spares),
        ] : null;
    }
}
