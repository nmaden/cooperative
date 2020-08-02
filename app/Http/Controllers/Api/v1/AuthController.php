<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use \Validator;

class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'surname' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        DB::transaction(function () use ($request) {
            
            $create = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'patronymic' => $request->patronymic,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
//            $hotel_id = User::query()->where('id', Auth::id())->hotels()->first();
//            return $hotel_id;
//            Auth::user()->hotels()->first();
//            $hotel_id = User::query()
//                ->where('id', '=', Auth::id())
//                ->with('responsible')
//                ->firstOrFail()
//                ->responsible
//                ->first();
//            if ($hotel_id->id == null) {
//
//            } else {
//                Hotel::find($hotel_id->id)->responsible()->syncWithoutDetaching($create->id);
//            }

            $create->syncRoles($request->role['name']);
//            $user = User::query()->where('id',$create->id)->first();
//            if($user->syncRoles($request->role['name'])){
//                return response()->json(['success' => 'Роль "'.$user->roles[0]->name.'" успешно присвоена пользователю - '.$user->surname.' '.$user->name], 200);
//            }

            return $create;
        }, 5);

        return response()->json(['status' => 201]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json($success, 200);
        }
        else{
            return response()->json(['error'=>'Unauthenticated'], 401);
        }
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json(['status' => 200]);
    }
}
