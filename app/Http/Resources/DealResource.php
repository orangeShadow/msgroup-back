<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
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
            'client' => new UserResource($this->client),
            'master' => new UserResource($this->master),
            'manufacturer' => new DealManufacturerResource($this->manufacturer),
            'model'        => new DeviceResource($this->model),
            'malfunction' => new MalfunctionResource($this->malfunction),
            'condition'   => new ConditionResource($this->condition),
            'point_a' => new DealPointResource($this->point_a),
            'point_b' => new DealPointResource($this->point_b),
            'serial' => $this->serial,
            'password' => $this->password,
            'dev_id' => $this->dev_id,
            'dev_id_password' => $this->dev_id_password,
            'completeness' => $this->completeness,
            'video_acceptance' => $this->video_acceptance,
            'video_diagnostics' => $this->video_diagnostics,
            'video_repair' => $this->video_repair,
            'client_mark' => $this->client_mark,
            'client_comment' => $this->client_comment,
            'master_mark' => $this->master_mark,
            'master_comment' => $this->master_comment,
            'delay_reason' => $this->delay_reason,
            'status' => config("statuses.{$this->status}"),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
