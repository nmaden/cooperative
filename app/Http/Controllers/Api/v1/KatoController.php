<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Kato\RegionResource;
use App\Models\Kato;
use Illuminate\Http\Request;

class KatoController extends Controller
{
    public function get_region() {
        $regions = Kato::query()->where('level','=',2)->get();
        return RegionResource::collection($regions);
    }

    public function get_area(Request $request) {
        $area = Kato::query()->where('parent_id','=',$request->parent_id)->get();
        return RegionResource::collection($area);
    }
    public function get_areas(Request $request) {
        $area = Kato::query()->whereIn('parent_id',$request->parent_id)->get();
        return RegionResource::collection($area);
    }

    public function get_locality(Request $request) {
        $locality = Kato::query()->where('parent_id','=',$request->parent_id)->get();
        return RegionResource::collection($locality);
    }
    public function get_localities(Request $request) {
        $locality = Kato::query()->whereIn('parent_id',$request->parent_id)->get();
        return RegionResource::collection($locality);
    }
}
