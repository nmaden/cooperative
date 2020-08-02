<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSearchResource extends JsonResource
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
//            'label'=>$this->name.' '.$this->surname.' '.$this->patronymic.' '.$this->email,
            'label'=>$this->name.' '.$this->surname.' '.$this->patronymic,
        ];
//        return parent::toArray($request);
    }
}
