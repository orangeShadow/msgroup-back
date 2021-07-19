<?php

namespace App\Http\Resources;

use App\Models\Api\Master;
use App\Models\Api\Point;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterResource extends JsonResource
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
            'name'       => (string)$this->name,
            'patronymic' => (string)$this->patronymic,
            'surname'    => (string)$this->surname,
            'phone'      => (string)$this->phone,
            'point_id' => $this->master_point(),
            'loading' => (int)$this->loading,
            'fine' => (float)$this->master_fine(),
        ];
    }
}
