<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CitizenshipsResource;
use App\Http\Resources\User\UserAllResource;
use App\Http\Resources\User\UserSearchResource;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use \Validator;

class UserController extends Controller
{

    // TODO: change this logic
    public function user(Request $request) {
        return $request->user();
    }

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'desc' => 'required',
            'sort_by' => 'required',
            'per_page' => 'required',
        ]); 
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        if ($request->desc == true) {
            $sort = 'desc';
        } else {
            $sort = 'asc';
        }
        // $auth_role = Auth::user()->with('roles')->first()->roles->first()->id;
        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;
        if ($auth_role === 1 or $auth_role === 2 or $auth_role === 3) {
            $all = User::query()->with('roles')->orderBy($request->sort_by, $sort)->paginate($request->per_page);
        }
        if ($auth_role === 4 || $auth_role ===5) {
            $hotel_id = Auth::user()->hotels()->first()->id;
            $users_id = DB::table('hotel_user')->select('*')->where('hotel_id', '=', $hotel_id)->get()->pluck('user_id');
            
            $all = User::query()
                ->with('roles')
                ->whereIn('id', $users_id)
                ->orderBy($request->sort_by, $sort)
                ->paginate($request->per_page);
        }

        return UserAllResource::collection($all);
    }

    public function get_user_email(Request $request) {
        $email = User::query()->where('client_id',$request->client_id)->first();
        
        return [
            'email' => $email->email
        ];
    }
    public function get_users_count(Request $request) {
            $users = DB::table('hotel_user')->where('hotel_id',$request->id)->get();

            return response()->json(['count' =>sizeof($users)], 200);
    }   

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $user = User::query()->findOrFail($request->id);
        return response()->json($user, 200);
    }

    public function me(Request $request)
    {
        $user = User::where('id', '=', Auth::id())
            ->with('roles')
            ->with('responsible')
            ->first();
        
        return response()->json($user, 200);
    }

    public function search(Request $request)
    {
        if ($request->search == "") {
            return response()->json([], 200);
        }
        $search_fio = User::query()->where('surname', 'like', '%' . $request->search . '%')->limit(20)->get();
        $search_email = User::query()->where('email', 'like', '%' . $request->search . '%')->limit(20)->get();

        $collection3 = $search_fio;
        $collection4 = $collection3->merge($search_email);
        return UserSearchResource::collection($collection4);
    }
    public function update(Request $request) {
        
     
        $auth_role = Auth::user()->with('roles')->first()->roles->first()->id;
        $user = User::where('id', '=', $request->id)
        ->with('roles')
        ->with('responsible')
        ->first();
        
        DB::table('model_has_roles')->where('model_id', $request->id)->update([
                'role_id' =>   $request->role
        ]);

        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->patronymic = $request->patronymic;
        $user->iin = $request->iin;

        if($request->password!=null) {
            $user->password = bcrypt($request->password);
        }
       
        
        $user->save();
        
        return response()->json(['success' => 'updated'], 200);
    }


    public function delete(Request $request) {
     
        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;


        if($auth_role==4 || $auth_role==1) {
            $user = User::where('id', '=', $request->id )
            ->with('roles')
            ->with('responsible')
            ->delete();

            DB::table('model_has_roles')->where('model_id',$request->id)->delete();
            DB::table('hotel_user')->where('user_id',$request->id)->delete();
     
            return response()->json(['success' => "Пользователь успешно удален"], 200);
        }
        else {
            return response()->json(['error' => "У вас нет права для удаление"], 422);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
          
            'email' => 'required|unique:users',
            'password' => 'required',
            'client_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        

        $check_exist = User::where("client_id",$request->client_id)->first();

        if(!$check_exist) {
            $create = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'client_id' => $request->client_id
            ]);
            $create->syncRoles('Пользователь МР');
            return response()->json(['success' => "Пользователь успешно создан"], 200);
        }
        else {

            return response()->json(['success' => "Личный кабинет существует"], 200);
        }
        
    }

    public function regula(Request $request)
    {
        $send = $request['data'][0]['ListVerifiedFields']['pFieldMaps'];
        if ($request['data'][0]['ListVerifiedFields']['pFieldMaps'] == null) {
            return 'error';
        }
        foreach ($send as $item) {
            if ($item['FieldType'] == 7) {
                $data['document_number'] = $item['Field_MRZ'];
            }
            if ($item['FieldType'] == 2) {
                $data['series_documents'] = $item['Field_MRZ'];
            }
            if ($item['FieldType'] == 5) {
                $data['date_birth'] = Carbon::parse($item['Field_MRZ'])->format('Y/m/d');
            }
            if ($item['FieldType'] == 4) {
                $data['date_issue'] = Carbon::parse($item['Field_Visual'])->format('Y/m/d');
            }
            if ($item['FieldType'] == 3) {
                $data['date_untill'] = Carbon::parse($item['Field_MRZ'])->format('Y/m/d');
            }
            if ($item['FieldType'] == 9) {
                $data['name'] = $item['Field_MRZ'];
            }
            if ($item['FieldType'] == 8) {
                $data['surname'] = $item['Field_MRZ'];
            }
            if ($item['FieldType'] == 8) {
                $data['surname'] = $item['Field_MRZ'];
            }
            if ($item['FieldType'] == 12) {
                if ($item['Field_MRZ'] == 'MALE') {
                    $data['gender'] = 'Мужской';
                }
                if ($item['Field_MRZ'] == 'M') {
                    $data['gender'] = 'Мужской';
                }
                if ($item['Field_MRZ'] == 'FEMALE') {
                    $data['gender'] = 'Женский';
                }
                if ($item['Field_MRZ'] == 'F') {
                    $data['gender'] = 'Женский';
                }
            }
            if ($item['FieldType'] == 1) {
                $find = Country::query()->where('name_eng', $item['Field_MRZ'])->get();
                $data['citizenship'] = CitizenshipsResource::collection($find);
            }

//            return $item['FieldType'];
        }
        return response()->json($data, 200);
//            if ($item->FieldType == 9) {;
//

    }

    public function my_count(Request $request)
    {
        $auth_role = Auth::user()->with('roles')->first()->roles->first()->id;
        if ($auth_role === 4 or $auth_role === 5) {
            $hotel_id = \App\User::query()
                ->where('id', '=', Auth::id())
                ->with('responsible')
                ->firstOrFail()
                ->responsible
                ->first()
                ->id;
            $data = Hotel::query()->findOrFail($hotel_id)->with('responsible')->count();
            return response()->json($data, 200);
        } else {
            $data = Hotel::query()->with('responsible')->count();
            return response()->json($data, 200);
        }

    }

    public function get_roles()
    {
        $user = auth()->user();
        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;
      
       
        if ($auth_role==2) {
            $roles = Role::query()->find([3, 4, 5]);
            return response()->json(['success' => $roles], 200);
        }
        if ($auth_role==3) {
            $roles = Role::query()->find([4, 5]);
            return response()->json(['success' => $roles], 200);
        }
        if ($auth_role==4 || $auth_role==5) {
            $roles = Role::query()->find([4, 5]);
            return response()->json(['success' => $roles], 200);
        }
        $roles = $roles = Role::query()->find([1, 2, 3, 4, 5, 6]);
        return response()->json(['success' => $roles], 200);
    }
}
