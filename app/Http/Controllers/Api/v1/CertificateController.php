<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use \Validator;

class CertificateController extends Controller
{
    public function show(Request $request) {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $find = Certificate::query()->where('hotel_id','=',$request->hotel_id)->orderBy('created_at','DESC')->get();
        return response()->json($find,200);
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date',
            'number' => 'required',
            'organization' => 'required',
            'BIN' => 'required',
            'star' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $create = Certificate::create($request->all());
        return response()->json($create,200);
    }
}
