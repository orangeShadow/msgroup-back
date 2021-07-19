<?php

namespace App\Http\Resources;

use App\Http\Resources\DeviceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ManufacturersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
