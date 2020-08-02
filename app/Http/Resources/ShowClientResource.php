<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowClientResource extends JsonResource
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
            'hotel_id'=>$this->hotel_id,
            'target_id'=>$this->target_id,
            'surname'=>$this->surname,
            'name'=>$this->name,
            'patronymic'=>$this->patronymic,
            'gender_id'=>$this->gender_id,
            'date_birth'=>$this->date_birth,
            'doctype_id'=>$this->doctype_id,
            'series_documents'=>$this->series_documents,
            'document_number'=>$this->document_number,
            'valid_until'=>$this->valid_until,
            'date_issue'=>$this->date_issue,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'kato_id'=>$this->kato_id,
            'gender'=>$this->gender,
            'doctype'=>$this->doctype,
            'Citizenship'=>$this->Citizenship,
            'transactions_count'=>$this->transactions_count,
            'transactions'=> ListTransactionClientResource::collection($this->transactions),

        ];
    }
}
