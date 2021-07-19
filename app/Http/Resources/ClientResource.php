<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'fio' => (string)trim($this->name.' '.$this->patronymic.' '.$this->surname),
//            'name'       => (string)$this->name,
//            'patronymic' => (string)$this->patronymic,
//            'surname'    => (string)$this->surname,
            'phone'      => (string)$this->phone,
            'amount'     => (float)$this->client_sum(),
            'mark'       => (int)$this->client_mark(),
            'discount'   => (float)$this->discount,
        ];
    }
}
