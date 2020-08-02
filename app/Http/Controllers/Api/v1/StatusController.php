<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Role\RoleListResource;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index() {
        return RoleListResource::collection(Status::all());
    }
    public function check_in() {
        return RoleListResource::collection(Status::find(['1','2']));
    }
    public function check_out() {
        return RoleListResource::collection(Status::find(['2','3']));
    }
}
