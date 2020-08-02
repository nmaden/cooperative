<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TargetResource;
use App\Models\Target;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    public function index() {
        return TargetResource::collection(Target::all());
    }
}
