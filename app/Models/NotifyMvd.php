<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifyMvd extends Model
{
    protected $table = 'notify_mvds';

    public function transaction()
    {
        return $this->belongsTo(\App\Models\Transaction::class, 'transaction_id', 'id');
    }

    public static function send($data) {
        $notify = new self;
        $notify->transaction_id = $data['transaction_id'];
        $notify->first_name = $data['first_name'];
        $notify->last_name = $data['last_name'];
        $notify->middle_name = $data['middle_name'];
        $notify->birthday = $data['birthday'];
        $notify->gender = $data['gender'];
        // $notify->residency = $data['residency'];
        $notify->purpose_visit = $data['purpose_visit'];
        $notify->phone = $data['phone'];
        $notify->email = $data['email'];
        $notify->check_in = $data['check_in'];
        $notify->check_out = $data['check_out'];
        $notify->citizenship = $data['citizenship'];
        $notify->document_type = $data['document_type'];
        $notify->document_series = $data['document_series'];
        $notify->document_number = $data['document_number'];
        $notify->document_date_start = $data['document_date_start'];
        $notify->document_date_end = $data['document_date_end'];
        $notify->hotel_user_first_name = $data['hotel_user_first_name'];
        $notify->hotel_user_last_name = $data['hotel_user_last_name'];
        $notify->hotel_user_middle_name = $data['hotel_user_middle_name'];
        $notify->hotel_document_number = $data['hotel_document_number'];
        $notify->hotel_bin = $data['hotel_bin'];
        $notify->hotel_name = $data['hotel_name'];
        $notify->hotel_region = $data['hotel_region'];
        $notify->hotel_address = $data['hotel_address'];
        $notify->hotel_house = $data['hotel_house'];
        $notify->hotel_apartment = $data['hotel_apartment'];
        $notify->save();
    }
}
