<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PushResource extends JsonResource
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
            'title' => $this->title,
            'body' => $this->body,
            'page_id' => $this->page_id,
            'param_id' => $this->param_id,
            'fresh' => (boolean)$this->fresh,
            'created_at' => $this->created_at,
        ];
    }
}
