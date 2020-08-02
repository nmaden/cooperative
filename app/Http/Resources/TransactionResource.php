<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class TransactionResource extends JsonResource
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
            'id'=>$this->id,
            'check_in'=>Carbon::parse($this->check_in)->format('d-m-Y H:i:s'),
            'check_out'=>Carbon::parse($this->check_out)->format('d-m-Y H:i:s'),
            'check_in_list'=>Carbon::parse($this->check_in)->format('d.m.Y'),
            'check_out_list'=>Carbon::parse($this->check_out)->format('d.m.Y'),
            'notification_on_mvd'=>$this->notification_on_mvd,
            'clients'=>$this->client->surname.' '.$this->client->name.' '.$this->client->patronymic,
            'client_id'=>$this->client->id,
            'Citizenship'=>$this->client->Citizenship->name_rus,
            'statuses_id'=>$this->statuses_id,
            'status'=>$this->status,
            'client'=>$this->client,
            'target'=>$this->client->target,
            'hotel'=>$this->hotel,
            'region'=>$this->hotel->region,
        ];
//        return parent::toArray($request);
    }
}
