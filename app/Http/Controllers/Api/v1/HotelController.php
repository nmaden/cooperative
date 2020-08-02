<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

use App\Http\Resources\Hotel\HotelIndexResource;
use App\Http\Resources\Role\RoleListResource;
use App\Models\Certificate;
use App\Models\Hotel;
use App\Models\EmailMessage;
use App\Models\HotelImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use \Validator;

class HotelController extends Controller
{
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
        $all = Hotel::query()
            ->with('region')
            ->with('area')
            ->with('locality')
            ->with('actual_certifications')
            ->orderBy($request->sort_by, $sort);

            
        if ($request->filter) {
            if ($request->filter['region_id'] and $request->filter['region_id'] != '') {
                $all->whereIn('region_id', $request->filter['region_id']);
            }
            if ($request->filter['locality_id'] and $request->filter['locality_id'] != '') {
                $all->whereIn('locality_id', $request->filter['locality_id']);
            }
            if ($request->filter['area_id'] and $request->filter['area_id'] != '') {
                $all->whereIn('area_id', $request->filter['area_id']);
            }
            if ($request->filter['search'] and $request->filter['search_value']) {
                if ($request->filter['search_value'] == 'БИН') {
                    $all->where('BIN', 'like', '%' . $request->filter['search'] . '%');
                } elseif ($request->filter['search_value'] == 'Наименование') {
                    $all->where('name', 'like', '%' . $request->filter['search'] . '%');
                } elseif ($request->filter['search_value'] == 'Юридическое лицо') {
                    $all->where('entity', 'like', '%' . $request->filter['search'] . '%');
                }
            }
            if ($request->filter['starts_filter']) {
                $all->whereHas('actual_certifications', function ($q) use ($request) {
                    $q->whereIn('star', $request->filter['starts_filter']);
                });
            }
            $all = $all->paginate($request->per_page);


        }
        return HotelIndexResource::collection($all);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'entity' => 'required',
            'region_id' => 'required|integer',
            'area_id' => 'required|integer',
            'locality_id' => 'nullable|integer',
            'street' => 'required',
            'house' => 'required',
            'number_rooms' => 'required|integer',
            'number_beds' => 'required|integer',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $hotel = Hotel::create($request->all());
        Certificate::create([
            'hotel_id' => $hotel->id,
            'start' => '2000-01-01',
            'end' => '2090-01-01',
            'number' => 0,
            'organization' => 0,
            'BIN' => 0,
            'star' => 0,
        ]);
        return response()->json(['id' => $hotel->id], 200);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $hotel = Hotel::query()
            ->where('id', '=', $request->id)
            ->with('region')
            ->with('area')
            ->with('locality')
            ->with('responsible')
            ->with('responsible.roles')
            ->with('actual_certifications')
            ->first();
        return response()->json($hotel, 200);
    }

    public function edit(Request $request)
    {
        $update = Hotel::findOrFail($request->id);

        $input = $request->except(['id']);

        $update->fill($input)->save();
        return $update;
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }
        $hotel = Hotel::findOrFail($request->id);

        $hotel->certifications()->delete();
        $hotel->delete();
        return response()->json($hotel, 200);
    }

    public function all()
    {
        return RoleListResource::collection(Hotel::all());
    }

    public function getByRegionId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'region_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $hotels = Hotel::select('id as value', 'name as label')->where('region_id', $request->region_id)->get();

        return response()->json($hotels, 200);

    }

    public function guest(Request $request)
    {

//        $validator = Validator::make($request->all(), [
//            'desc' => 'required',
//            'sort_by' => 'required',
//            'per_page' => 'required',
//        ]);
//        if ($validator->fails()) {
//            return response()->json(['error' => $validator->messages()], 422);
//        }
//        if ($request->desc == true) {
//            $sort = 'desc';
//        } else {
//            $sort = 'asc';
//        }
        $all = Hotel::query()
            ->with('region')
            ->with('area')
            ->with('locality')
            ->with('actual_certifications');
//            ->orderBy($request->sort_by, $sort);
        if ($request->filter) {
            if ($request->filter['region_id'] and $request->filter['region_id'] != '') {
                $all->whereIn('region_id', $request->filter['region_id']);
            }
            if ($request->filter['starts_filter']) {
                $all->whereHas('actual_certifications', function ($q) use ($request) {
                    $q->whereIn('star', $request->filter['starts_filter']);
                });
            }
        }

        $all = $all->paginate($request->per_page);


        return HotelIndexResource::collection($all);
    }

    public function public()
    {
        $hotels = Hotel::query()
            ->where('show_kt', 1)
            ->with('actual_certifications')
            ->with('region')
            ->with('area')
            ->with('locality')->get();
        return view('hotels', ['hotels' => $hotels]);
    }
    // public function showMessage(){
    //     $properties = EmailMessage::all();
    //     $id = DB::table('hotel_user')->where('user_id',Auth::User()->id)->first();
    //     // dd($id);
    //     $hotel = DB::table('hotels')->where('id', $id->hotel_id)->first();
    //     // // dd($hotel);
    //     // // dd($properties[0]->hotel());
    //     // // dd(Auth::user()->hotel());
    //     // // dd(hotel());
    //      $colors = ['#A5A5A5', '#03FF59'];
    //     return view('/test', [
    //         'properties' => $properties,
    //         'hotelId' => $hotel,
    //         'colors' => $colors 
    //     ]);
    // }
     
    // public function editMessage(Request $request, $id){
    //     //$properties = EmailMessage::hotel()->where('id', $id)->first();
    //     //dd($properties);
    //     if($properties = Hotel::where('id', $id)->first() != null){
    //         if (//$request->has('color') &&
    //             //$request->has('appeal') &&
    //             //$request->has('welcome_text') &&
    //             // $request->has('status_bron') &&
    //             // $request->has('status_pay') &&
    //             // $request->has('status_cancel') &&
    //             $request->has('signature_text') 
    //         ){            
    //             $properties = new EmailMessage;
    //             $properties->hotel_id = $id;
    //             $properties->color = '';
    //             $properties->appeal = $request->input('appeal');
    //             $properties->welcome_text = '';
    //             $properties->status_bron = '';
    //             $properties->status_pay = '';
    //             $properties->status_cancel = '';
    //             $properties->status_weather = '';
    //             $properties->signature_text = '';
    //             $properties->save();
    //         }else{
    //             $request->session()->flash('error', 'Заполните все поля!');
    //             return redirect('/test');
    //             // return response()->json(['error' => $validator->messages()], 422);            
    //         }
    //     // return response()->json($hotel, 200);
    //     return view('/test');
    //     }
    // }

    public function showTypesMessages(Request $request) {
        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUser = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->where('hotel_id', $request->input('hotel_id'))
                ->first();
        
            if (!$hotelUser) {
                return response()->json(['error' => 'У вас нет полномочии'], 400);
            }
        }

        else if ($role_id !== 1 && $role_id !== 2 && $role_id !== 3) {
            return response()->json(['error' => 'У вас нет полномочии'], 400);
        }

        $emailMessages = EmailMessage::where('type', 'upon_booking')->first();
        $checkInDay = $emailMessages->check_in_day_notice;
        $testEmail = $emailMessages->test_email;
        
        $emailMessages = EmailMessage::where('type', 'upon_arrival')->first();
        $checkOutDay = $emailMessages->check_out_day_notice;
                
        return response()->json([
            'checkIn' => $checkInDay,
            'checkOut' => $checkOutDay,
            'testEmail' => $testEmail
        ], 200);
    }

    public function editTypesMessages(Request $request) {
        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUser = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->where('hotel_id', $request->input('hotel_id'))
                ->first();
        
            if (!$hotelUser) {
                return response()->json(['error' => 'У вас нет полномочии'], 400);
            }
        }

        else if ($role_id !== 1 && $role_id !== 2 && $role_id !== 3) {
            return response()->json(['error' => 'У вас нет полномочии'], 400);
        }

        if ($request->has('check_in_day_notice') &&
            $request->has('check_out_day_notice') &&
            $request->has('test_email')
        ){            
            $emailMessages = EmailMessage::where('type', 'upon_booking')->first();
            if (!$emailMessages) {
                $emailMessages = new EmailMessage;
            }
            $emailMessages->check_in_day_notice = $request->input('check_in_day_notice');
            $emailMessages->test_email = $request->input('test_email');
            $emailMessages->save();
    
            $emailMessages = EmailMessage::where('type', 'upon_arrival')->first();
            if (!$emailMessages) {
                $emailMessages = new EmailMessage;
            }
            $emailMessages->check_out_day_notice = $request->input('check_out_day_notice');
            $emailMessages->test_email = $request->input('test_email');
            $emailMessages->save();
            
            $emailMessages = EmailMessage::where('type', 'upon_departure')->first();
            if (!$emailMessages) {
                $emailMessages = new EmailMessage;
            }
            $emailMessages->test_email = $request->input('test_email');
            $emailMessages->save();
            return response()->json(true, 200);
        }

        return response()->json(['error' => 'Ошибка, заполните все поля'], 400);
    }


    public function showMessage(Request $request) {
        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUser = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->where('hotel_id', $request->input('hotel_id'))
                ->first();
        
            if (!$hotelUser) {
                return response()->json(['error' => 'У вас нет полномочии'], 400);
            }
        }

        else if ($role_id !== 1 && $role_id !== 2 && $role_id !== 3) {
            return response()->json(['error' => 'У вас нет полномочии'], 400);
        }
        
        $message = EmailMessage::where('type', $request->type)->first();
        
        
        return response()->json([
            'success' => "success",
            'hotel' => $message
        ], 200);

        
        // return view('/test', [
        //     // 'hotelId' => $hotel,
        //     'colors' => $colors 
        // ]);
        // return response()->json(true, 200);
    }

    public function editMessage(Request $request) {
        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUser = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->where('hotel_id', $request->input('hotel_id'))
                ->first();
        
            if (!$hotelUser) {
                return response()->json(['error' => 'У вас нет полномочии'], 400);
            }
        }

        else if ($role_id !== 1 && $role_id !== 2 && $role_id !== 3) {
            return response()->json(['error' => 'У вас нет полномочии'], 400);
        }

        
        $message = EmailMessage::where('type', $request->input('type'))->first();

        
        if (!$message) {
            $message = new EmailMessage;
        }
        
        if ($request->has('color') &&
            $request->has('appeal') &&
            $request->has('text') &&
            $request->has('type') &&
            $request->has('subject_text') &&
            $request->has('status_booking') &&
            $request->has('status_pay') &&
            $request->has('status_cancel') &&
            $request->has('signature_text') 
        ){            
            $message->color = $request->input('color');
            $message->appeal = $request->input('appeal');
            $message->text = $request->input('text');
            $message->type = $request->input('type');
            $message->subject_text = $request->input('subject_text');
            $message->status_booking = $request->input('status_booking');
            $message->status_pay = $request->input('status_pay');
            $message->status_cancel = $request->input('status_cancel');
            $message->status_weather = '0';
            $message->signature_text = $request->input('signature_text');
            $message->save();
            return response()->json(true, 200);
        }

        return response()->json(['error' => 'Ошибка, заполните все поля'], 400);
    }


    public function showPlacementProfile(Request $request) {
        
        $id = DB::table('hotel_user')->where('user_id', Auth::user()->id)->first();
        $hotel = Hotel::where('id', $id->hotel_id)->first();
        if (!$hotel) {
            return response()->json(['error' => 'Ошибка, Нет такой гостиницы'], 400);
        }
        $hotelUser = DB::table('hotel_user')
            ->where('user_id', Auth::user()->id)
            ->where('hotel_id', $hotel->id)
            ->first();
        if (!$hotelUser) {
            return response()->json(['error' => 'Ошибка, Вы не являетесь владельцем гостиницы'], 400);
        }
        
        $certificates = DB::table('certificates')->where('hotel_id', $hotel->id)->first();

        $hotelImages = HotelImage::where('hotel_id', $hotel->id)->get();
        return response()->json([
            'hotel' => $hotel,
            'certificates' => $certificates,
            'images' => $hotelImages
        ], 200);

        
        // return view('test-placement-profile', [
        //     'hotel' => $hotel,
        //     'certificates' => $certificates,
        //     'images' => $hotelImages
        // ]);
    }

    public function editPlacementProfile(Request $request) {
        $user = DB::table('hotel_user')->where('user_id', Auth::user()->id)->first();
        $hotel = Hotel::where('id', $user->hotel_id)->first();
        // $hotel = Hotel::where('id', $request->input('id'))->first();
        if (!$hotel) {
            return response()->json(['error' => 'Ошибка, Нет такой гостиницы'], 400);
        }
        $hotelUser = DB::table('hotel_user')
            ->where('user_id', Auth::user()->id)
            ->where('hotel_id', $hotel->id)
            ->first();
        if (!$hotelUser) {
            return response()->json(['error' => 'Ошибка, Вы не являетесь владельцем гостиницы'], 400);
        }

        if ($request->has('id') &&
            $request->has('name') &&
            $request->has('entity') &&
            // $request->has('min_stat_id') &&
            $request->has('region_id') &&
            $request->has('area_id') &&
            $request->has('locality_id') &&
            $request->has('street') &&
            $request->has('house') &&
            $request->has('BIN') &&
            $request->has('PMS') &&
            $request->has('description') &&
            $request->has('contact_info') &&
            $request->has('site') &&
            $request->has('booking_link') &&
            $request->has('tripadvisor_link') &&
            $request->has('coortdinate_on_map') &&
            $request->has('service_wifi') &&
            $request->has('service_breakfast') &&
            $request->has('service_reseption_round_day') &&
            $request->has('service_daily_cleaning')
        ) {
            $hotel->name = $request->input('id');
            $hotel->name = $request->input('name');
            $hotel->entity = $request->input('entity');
            // $hotel->min_stat_id = $request->input('min_stat_id');
            $hotel->region_id = $request->input('region_id');
            $hotel->area_id = $request->input('area_id');
            $hotel->locality_id = $request->input('locality_id');
            $hotel->street = $request->input('street');
            $hotel->house = $request->input('house');
            $hotel->BIN = $request->input('BIN');
            $hotel->PMS = $request->input('PMS');
            $hotel->description = $request->input('description');
            $hotel->contact_info =  $request->input('contact_info');
            $hotel->site = $request->input('site');
            $hotel->booking_link = $request->input('booking_link');
            $hotel->tripadvisor_link = $request->input('tripadvisor_link');
            $hotel->coortdinate_on_map = $request->input('coortdinate_on_map');
            $hotel->service_wifi = $request->input('service_wifi');
            $hotel->service_breakfast = $request->input('service_breakfast');
            $hotel->service_reseption_round_day = $request->input('service_reseption_round_day');
            $hotel->service_daily_cleaning = $request->input('service_daily_cleaning');

            $hotel->save();
            return response()->json(true, 200);
        } 
            return response()->json(['error' => 'Ошибка, заполните все поля'], 400);            
    }

    public function uploadImagePlacementProfile(Request $request) {
        
        $hotel = Hotel::where('id', $request->input('hotel_id'))->first();

        if (!$hotel) {
            return response()->json(['error' => 'Ошибка, Нет такой гостиницы'], 400);
        }
        $hotelUser = DB::table('hotel_user')
            ->where('user_id', Auth::user()->id)
            ->where('hotel_id', $hotel->id)
            ->first();
        if (!$hotelUser) {
            return response()->json(['error' => 'Ошибка, Вы не являетесь владельцем гостиницы'], 400);
        }
        $hotelImage = new HotelImage;
        $request->validate([
            'image' => 'mimes:jpg,jpeg,png,bmp,tiff',
        ]);
        $extension = $request->image->getClientOriginalExtension();
        $path = 'storage/hotel/images/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';
        $file = 'hotel-image-' . time() . '.' . $extension;
        $request->image->move($path, $file);
        $hotelImage->image = '/' . $path . $file;
        $hotelImage->thumbnail = '/' . $path . $file;
        $hotelImage->hotel_id = $hotel->id;
        $result = $hotelImage->save();
            
        return response()->json($result, 200);
    }

    public function deleteImagePlacementProfile(Request $request) {
        $hotelImage = HotelImage::where('id', $request->input('id'))->first();
        
        if (!$hotelImage) {
            return response()->json(['error' => 'Нет загруженных картинок'], 400);
        }

        $hotelUser = DB::table('hotel_user')
            ->where('user_id', Auth::user()->id)
            ->where('hotel_id', $hotelImage->hotel_id)
            ->first();
        if (!$hotelUser) {
            return response()->json(['error' => 'Ошибка, Вы не являетесь владельцем гостиницы'], 400);
        }
        
        $result = $hotelImage->delete();

        return response()->json($result, 200);
    }    

    public function testUponBooking(){
        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUser = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->where('hotel_id', $request->input('hotel_id'))
                ->first();
        
            if (!$hotelUser) {
                return response()->json(['error' => 'У вас нет полномочии на эту гостиницу'], 400);
            }
        }

        else if ($role_id !== 1 && $role_id !== 2 && $role_id !== 3) {
            return response()->json(['error' => 'У вас нет полномочии на эту гостиницу'], 400);
        }

        $emailMessage = EmailMessage::where('type', 'upon_booking')->first();
        

        // return view('emails\notification-test', [
        //     'emailProperties' => $emailMessage,
        // ]);

        Mail::send('emails.notification-test', ['emailProperties' => $emailMessage], 
            function ($m) use ($emailMessage) {
            $m->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
            $m->to($emailMessage->test_email, 'hotel')->subject($emailMessage->subject_text);
        });
    }

    public function testUponArrival() {
        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUser = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->where('hotel_id', $request->input('hotel_id'))
                ->first();
        
            if (!$hotelUser) {
                return response()->json(['error' => 'У вас нет полномочии на эту гостиницу'], 400);
            }
        }

        else if ($role_id !== 1 && $role_id !== 2 && $role_id !== 3) {
            return response()->json(['error' => 'У вас нет полномочии на эту гостиницу'], 400);
        }

        $emailMessage = EmailMessage::where('type', 'upon_arrival')->first();
        

        // return view('emails\notification-test', [
        //     'emailProperties' => $emailMessage,
        // ]);

        Mail::send('emails.notification-test', ['emailProperties' => $emailMessage], 
            function ($m) use ($emailMessage) {
            $m->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
            $m->to($emailMessage->test_email, 'hotel')->subject($emailMessage->subject_text);
        });
    }

    public function testUponDeparture() {
        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUser = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->where('hotel_id', $request->input('hotel_id'))
                ->first();
        
            if (!$hotelUser) {
                return response()->json(['error' => 'У вас нет полномочии на эту гостиницу'], 400);
            }
        }

        else if ($role_id !== 1 && $role_id !== 2 && $role_id !== 3) {
            return response()->json(['error' => 'У вас нет полномочии на эту гостиницу'], 400);
        }

        $emailMessage = EmailMessage::where('type', 'upon_departure')->first();
        

        // return view('emails\notification-test', [
        //     'emailProperties' => $emailMessage,
        // ]);

        Mail::send('emails.notification-test', ['emailProperties' => $emailMessage], 
            function ($m) use ($emailMessage) {
            $m->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
            $m->to($emailMessage->test_email, 'hotel')->subject($emailMessage->subject_text);
        });        
    }


    // public function showDayNotice(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'id' => 'integer|required',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['error' => $validator->messages()], 422);
    //     }

    //     $days = Hotel::query()
    //         // ->select('check_in_day_notice, check_out_day_notice')
    //         ->where('id', $request->input('id'))
    //         // ->with('check_in_notice')
    //         // ->with('check_out_notice')
    //         ->first();
    //     return response()->json($days, 200);     
    // }

    // public function updateDayNotice($request){
    //     $count = Hotel::findOrFail($request->id);

    //     $count->check_in_notice = $request->check_in_notice;
    //     $count->check_out_notice = $request->check_out_notice;
    //     $count->save();
    //     return response()->json(['success' => 'Запись обновлена'], 200);        
    // }

    

}


