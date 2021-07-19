<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealsCourierResource extends JsonResource
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
            'point_a' => new DealPointResource($this->point_a),
            'point_b' => new DealPointResource($this->point_b),
            'status' => config("statuses.{$this->status}"),
            'created_at' => $this->created_at,
        ];
    }
}
