<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TosResource extends JsonResource
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
            'html' => is_object($this)? '' : $this->html,
        ];
    }
}
