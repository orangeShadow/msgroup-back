<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealManagerResource extends JsonResource
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
            'client' => new ClientResource($this->client),
            'manufacturer' => new DealManufacturerResource($this->manufacturer),
            'model'        => new DeviceResource($this->model),
            'serial' => $this->serial,
            'completeness' => $this->completeness,
            'condition' => new DealConditionResource($this->condition),
            'malfunction' => new MalfunctionResource($this->malfunction),
            'point_a' => new DealPointResource($this->point_a),
            'point_b' => new DealPointResource($this->point_b),
            'malfunctions' => DealMalfunctionResource::collection($this->malfunctions),
            'spares' => SpareResource::collection($this->spares),
            'video_acceptance' => $this->video_acceptance,
            'video_diagnostics' => $this->video_diagnostics,
            'video_repair' => $this->video_repair,
            'client_mark' => $this->client_mark,
            'client_comment' => $this->client_comment,
            'status' => config("statuses.{$this->status}"),
            'created_at' => $this->created_at,
        ];
    }
}
