<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FineResource extends JsonResource
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
            'id' => (int)$this->id,
            'user_id' => (int)$this->user_id,
            'amount'  => (float)$this->amount,
            'total_amount'  => (float)$this->total_amount(),
            'date_begin' => (string)$this->date_begin,
            'date_end'   => (string)$this->date_end,
        ];
    }
}
