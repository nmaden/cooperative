<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ShowTransactionEditingResource extends JsonResource
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
            'id' => $this->id,
            'client_id' => $this->client_id,
            'statuses_id'=>$this->statuses_id,
            'number'=>$this->number,
            'check_in_date'=>Carbon::parse($this->check_in)->format('Y/m/d'),
            'check_in_time'=>Carbon::parse($this->check_in)->format('H:i'),
            'check_out_date'=>Carbon::parse($this->check_out)->format('Y/m/d'),
            'check_out_time'=>Carbon::parse($this->check_out)->format('H:i'),
            'start_check_date'=>Carbon::parse($this->start_check_date)->format('Y/m/d'),
            'end_check_date'=>Carbon::parse($this->end_check_date)->format('Y/m/d'),
            'status'=>$this->status,
            'comment'=>$this->comment,
            'client'=>new ShowClientTransactionEditingResource($this->client),
        ];
        return parent::toArray($request);
    }
}
