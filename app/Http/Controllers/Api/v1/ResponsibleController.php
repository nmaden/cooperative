<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class ResponsibleController extends Controller
{
    public function show(Request $request)
    {
        $users = Hotel::query()->where('id','=',$request->id)
            ->with('responsible')->firstOrFail();
        return response()->json($users, 200);
    }

    public function create(Request $request) {
//        Hotel::find($request->id)->users()->detach();
//        foreach ($request->items as $item) {
//            Hotel::find($request->id)->users()->attach($item['user_id']);
//        }
        $make = Hotel::find($request->id)->responsible()->syncWithoutDetaching($request->user_id);
        return response()->json($make, 200);
    }

    public function delete(Request $request) {
        $del = Hotel::find($request->id)->responsible()->detach($request->user_id);
        return response()->json($del, 200);
    }
}
