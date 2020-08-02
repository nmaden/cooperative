<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctypeResource;
use App\Models\Doctype;
use Illuminate\Http\Request;

class DoctypeController extends Controller
{
    public function index() {
        return DoctypeResource::collection(Doctype::all());
    }
}
