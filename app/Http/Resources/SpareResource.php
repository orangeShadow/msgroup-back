<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpareResource extends JsonResource
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
            'price' => $this->price,
        ] : null;
    }
}
