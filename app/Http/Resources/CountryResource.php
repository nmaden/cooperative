<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
          'label_eng'=>$this->name_eng,
          'flag'=>$this->flag,
        ];
    }
}
