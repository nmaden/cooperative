<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'min_stat_id'=>$this->min_stat_id,
            'name'=>$this->name,
            'description'=>$this->description,
            'region_id'=>$this->region_id,
            'region'=>$this->region,
            'area'=>$this->area,
            'area_id'=>$this->area_id,
            'locality_id'=>$this->locality_id,
            'locality'=>$this->locality,
            'street'=>$this->street,
            'house'=>$this->house,
            'BIN'=>$this->BIN,
            'PMS'=>$this->PMS,
            'number_rooms'=>$this->number_rooms,
            'number_beds'=>$this->number_beds,
            'entity'=>$this->entity,
            'type'=>$this->type,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'actual_certifications'=>$this->actual_certifications,
            'show_kt'=>$this->show_kt,
        ];
//        return parent::toArray($request);
    }
}
