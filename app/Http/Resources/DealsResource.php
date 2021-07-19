<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealsResource extends JsonResource
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
            'manufacturer' => new DealManufacturerResource($this->manufacturer),
            'model'        => new DeviceResource($this->model),
            'status' => config("statuses.{$this->status}"),
            'created_at' => $this->created_at,
        ];
    }
}
