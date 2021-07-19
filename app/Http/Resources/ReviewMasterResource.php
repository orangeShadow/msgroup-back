<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewMasterResource extends JsonResource
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
            'mark' => $this->master_mark,
            'comment' => $this->master_comment,
            'date' => date('d.m.Y', strtotime($this->created_at))
        ];
    }
}
