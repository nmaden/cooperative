<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class NotifyMvdResource extends JsonResource
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
            'fullname' => $this->last_name . ' ' . $this->first_name . ($this->middle_name ? $this->middle_name : ''),
            'citizenship' => $this->citizenship,
            'purpose_visit' => $this->purpose_visit,
            'hotel' => $this->transaction->hotel,
            'address' => $this->hotel_region . ' ' . $this->hotel_address . ' ' . $this->hotel_house . ($this->hotel_apartment ? $this->hotel_apartment : ''),
            'status' => $this->status
        ];
    }
}
