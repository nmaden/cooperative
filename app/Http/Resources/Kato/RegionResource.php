<?php

namespace App\Http\Resources\Kato;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
            'value'=>$this->id,
            'label'=>$this->name_rus,
        ];
//        return parent::toArray($request);
    }
}
