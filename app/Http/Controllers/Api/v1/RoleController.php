<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Role\RoleListResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $auth_role = Auth::user()->with('roles')->first()->roles->first();
        if ($auth_role->id === 1) {
            $result = Role::query()->find(['2', '3', '4', '5']);
        }
        if ($auth_role->id === 2) {
            $result = Role::query()->find(['3', '4', '5']);
        }
        if ($auth_role->id === 3) {
            $result = Role::query()->find(['4', '5']);
        }
        if ($auth_role->id === 4) {
            $result = Role::query()->find(['5']);
        }
        return RoleListResource::collection($result);
    }
}
