<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MigrationResource;
use App\Http\Resources\ShowClientResource;
use App\Http\Resources\ShowTransactionEditingResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\NotifyMvdResource;
use App\Models\Client;
use App\Models\Country;
use App\Models\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RegistryController extends Controller
{
    public function create(Request $request)
    {
        $hotel = User::query()
            ->where('id', '=', Auth::id())
            ->with('responsible')
            ->firstOrFail()
            ->responsible
            ->first();
      
        $duplicate = Client::query()
            ->where('document_number', '=', $request->document_number)
            ->where('surname', '=', $request->surname)
            ->where('date_birth', $request->date_birth)
            ->where('hotel_id', $hotel->id)
            ->where('gender_id', '=', $request->gender_id)->first();

        $country = \App\Models\Country::where('id', $request->input('kato_id'))->first();
        
        if (!$country) {
            return response()->json([
                'error' => "Ошибка при указаний страны"
            ], 400);
        }

        $docType = \App\Models\Doctype::where('id', $request->input('doctype_id'))->first();
        
        if (!$docType) {
            return response()->json([
                'error' => "Ошибка при указаний типа документа"
            ], 400);
        }

        $target = null;

        if ($request->has('target_id')) {
            $target = \App\Models\Target::where('id', $request->input('target_id'))->first();
        
            if (!$target) {
                return response()->json([
                    'error' => "Ошибка при указаний целя визита"
                ], 400);
            }
        }

       
        $request['hotel_id'] = $hotel->id;
       
        if ($duplicate == null) {
          
            $create = $request->except(
                'check_in',
                'check_in_time',
                'check_out',
                'check_out_time',
                'comment',
                'number',
                'status',
                'end_check_date',
                'start_check_date',
                'notify_mvd',
                'welcome_message'
            );
                
            $client_id = Client::create($create);
            
            $transaction = Transaction::create([
                'client_id' => $client_id->id,
                'statuses_id' => $request->status,
                'number' => $request->number,
                'check_in' => Carbon::parse($request->check_in . ' ' . $request->check_in_time),
                'check_out' => Carbon::parse($request->check_out . ' ' . $request->check_out_time),
                'start_check_date' => $request->start_check_date,
                'end_check_date' => $request->end_check_date,
                'hotel_id' => $hotel->id,
                'notification_on_mvd' => $request->input('notify_mvd') ? 1 : 0,
            ]);

            if ($request->input('notify_mvd')) {
                $data = [
                    'transaction_id' => $transaction->id,
                    'first_name' => $request->input('name'), // Имя
                    'last_name' => $request->input('surname'), // Фамилия
                    'middle_name' => $request->input('patronymic'), // Отчество
                    'birthday' => $request->input('date_birth'),
                    'gender' => $request->input('gender_id') == '2' ? 'male' : 'female',
                    // 'residency' => $request->input('patronymic'),
                    'purpose_visit' => $target ? $target->name_rus : null, // Цель визита
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'check_in' => Carbon::parse($request->check_in . ' ' . $request->check_in_time),
                    'check_out' => Carbon::parse($request->check_out . ' ' . $request->check_out_time),
                    'citizenship' => $country->name_rus, // Гражданство
                    'document_type' => $docType->name_rus, // TODO: check this type
                    'document_series' => $request->input('series_documents'),
                    'document_number' => $request->input('document_number'),
                    'document_date_start' => $request->input('date_issue'),
                    'document_date_end' => $request->input('valid_until'),
                    'hotel_user_first_name' => null, // Имя владельца квартиры
                    'hotel_user_last_name' => null, // Фамилия владельца квартиры
                    'hotel_user_middle_name' => null, // Отчество владельца квартиры
                    'hotel_document_number' => null,
                    'hotel_bin' => $hotel->BIN,
                    'hotel_name' => $hotel->name,
                    'hotel_region' => $hotel->region->name_rus,
                    'hotel_address' => $hotel->street,
                    'hotel_house' => $hotel->house, // Квартира
                    'hotel_apartment' => null, // Квартира
                ];

                \App\Jobs\NotifyMvd::dispatch($data);
                // \App\Models\NotifyMvd::send($data);
            }

            return response()->json([
                'success' => "Успешно зарегистрирован пользователь"
            ], 200);
        } else {
            
            $transaction = Transaction::create([
                'client_id' => $duplicate->id,
                'statuses_id' => $request->status,
                'number' => $request->number,
                'check_in' => Carbon::parse($request->check_in . ' ' . $request->check_in_time),
                'check_out' => Carbon::parse($request->check_out . ' ' . $request->check_out_time),
                'start_check_date' => $request->start_check_date,
                'end_check_date' => $request->end_check_date,
                'hotel_id' => $hotel->id,
                'notification_on_mvd' => $request->input('notify_mvd') ? 1 : 0,
            ]);

            if ($request->input('notify_mvd')) {
                $data = [
                    'transaction_id' => $transaction->id,
                    'first_name' => $request->input('name'), // Имя
                    'last_name' => $request->input('surname'), // Фамилия
                    'middle_name' => $request->input('patronymic'), // Отчество
                    'birthday' => $request->input('date_birth'),
                    'gender' => $request->input('gender_id') == '2' ? 'male' : 'female',
                    // 'residency' => $request->input('patronymic'),
                    'purpose_visit' => $target ? $target->name_rus : null, // Цель визита
                    'phone' => $request->input('phone'),
                    'email' => $request->input('email'),
                    'check_in' => Carbon::parse($request->check_in . ' ' . $request->check_in_time),
                    'check_out' => Carbon::parse($request->check_out . ' ' . $request->check_out_time),
                    'citizenship' => $country->name_rus, // Гражданство
                    'document_type' => $docType->name_rus, // TODO: check this type
                    'document_series' => $request->input('series_documents'),
                    'document_number' => $request->input('document_number'),
                    'document_date_start' => $request->input('date_issue'),
                    'document_date_end' => $request->input('valid_until'),
                    'hotel_user_first_name' => null, // Имя владельца квартиры
                    'hotel_user_last_name' => null, // Фамилия владельца квартиры
                    'hotel_user_middle_name' => null, // Отчество владельца квартиры
                    'hotel_document_number' => null,
                    'hotel_bin' => $hotel->BIN,
                    'hotel_name' => $hotel->name,
                    'hotel_region' => $hotel->region->name_rus,
                    'hotel_address' => $hotel->street,
                    'hotel_house' => $hotel->house, // Квартира
                    'hotel_apartment' => null, // Квартира
                ];

                \App\Jobs\NotifyMvd::dispatch($data);
                // \App\Models\NotifyMvd::send($data);
            }

            return response()->json([
                'success' => "Успешно зарегистрирован ранее зарегистрированный пользователь"
            ], 200);
        }
    }

    public function count(Request $request)
    {
       
        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;
        
        if ($auth_role === 4 or $auth_role === 5) {
            $hotel_id = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();
            
            $result['list'] = Transaction::query()
                ->where('statuses_id', $request->status)
                ->where('hotel_id', $hotel_id->id)
                ->with('client')
                ->get();
            $result['hotel'] = $hotel_id;
           
            $result['count']['arriving'] = Transaction::query()
                ->where('hotel_id', $hotel_id->id)
                ->select(DB::raw('count(*) as arriving'))
                ->first();
            $result['count']['arrived'] = Transaction::query()
                ->select(DB::raw('count(*) as arrived'))
                ->where('hotel_id', $hotel_id->id)
                ->whereDate('check_in', '=', Carbon::now())
                ->first();
            $result['count']['living'] = Transaction::query()
                ->select(DB::raw('count(*) as living'))
                ->where('hotel_id', $hotel_id->id)
                ->where('statuses_id', 2)
                ->first();
            $result['count']['dropout'] = Transaction::query()
                ->select(DB::raw('count(*) as dropout'))
                ->where('statuses_id', 3)
                ->where('hotel_id', $hotel_id->id)
                ->first();
            return response()->json($result, 200);
        }
        elseif ($auth_role === 1 or $auth_role === 2 or $auth_role === 3) {
            $result['list'] = Transaction::query()
                ->where('statuses_id', $request->status)
                ->with('client')
                ->get();
            $result['count']['arriving'] = Transaction::query()
                ->select(DB::raw('count(*) as arriving'))
                ->first();
            $result['count']['arrived'] = Transaction::query()
                ->select(DB::raw('count(*) as arrived'))
                ->whereDate('check_in', '=', Carbon::now())
                ->first();
            $result['count']['living'] = Transaction::query()
                ->select(DB::raw('count(*) as living'))
                ->where('statuses_id', 2)
                ->first();
            $result['count']['dropout'] = Transaction::query()
                ->select(DB::raw('count(*) as dropout'))
                ->where('statuses_id', 3)
                ->first();
            return response()->json($result, 200);
        }
    }

    public function delete_transaction(Request $request)
    {
        $hotel = DB::table('hotel_user')->where('user_id', Auth::user()->id)->first();
        $transaction = Transaction::where('hotel_id',$hotel->hotel_id)->where('client_id',$request->id)->first();
        
        if (!$transaction) {
            return response()->json(['error' => 'Транзакция не существует'], 200);
        }

        $notifyMvd = \App\Models\NotifyMvd::where('transaction_id',$transaction->id)->delete();
        
        $transactionResultDelete = $transaction->delete();
        $clientResultDelete = Client::where('hotel_id',$hotel->hotel_id)->where('id',$request->id)->delete();

        if($clientResultDelete && $transactionResultDelete) {
            return response()->json(['success'=>'Успешно удален'], 200);
        }
        else {
            return response()->json(['error'=>'Ошибка'], 200);
        }
    }

    public function list(Request $request)
    {
        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;

        $queryTransaction = Transaction::with('client')->select('transactions.*');
        
        $queryTransaction->leftJoin('clients', function($join) {
            $join->on('transactions.client_id', 'clients.id');
        });

        if ($request->has('filter.check_in_date_from') && $request->filter['check_in_date_from'] != '') $queryTransaction->where('transactions.check_in', '>=', str_replace("/", "-", $request->filter['check_in_date_from']).' 00:00:00');
        if ($request->has('filter.check_in_date_to') && $request->filter['check_in_date_to'] != '') $queryTransaction->where('transactions.check_in', '<=', str_replace("/", "-", $request->filter['check_in_date_to']).' 23:59:59');
        if ($request->has('filter.check_out_date_from') && $request->filter['check_out_date_from'] != '') $queryTransaction->where('transactions.check_out', '>=', str_replace("/", "-", $request->filter['check_out_date_from']).' 00:00:00');
        if ($request->has('filter.check_out_date_to') && $request->filter['check_out_date_to'] != '') $queryTransaction->where('transactions.check_out', '<=', str_replace("/", "-", $request->filter['check_out_date_to']).' 23:59:59');
        if ($request->has('filter.surname') && $request->filter['surname'] != '') $queryTransaction->where('clients.surname', 'like', $request->filter['surname'].'%');
        if ($request->has('filter.name') && $request->filter['name'] != '') $queryTransaction->where('clients.name', 'like', $request->filter['name'].'%');
        if ($request->has('filter.document_number') && $request->filter['document_number'] != '') $queryTransaction->where('clients.document_number', 'like', $request->filter['document_number'].'%');
        if ($request->has('filter.phone') && $request->filter['phone'] != '') $queryTransaction->where('clients.phone', 'like', '%'.$request->filter['phone'].'%');
        if ($request->has('filter.email') && $request->filter['email'] != '') $queryTransaction->where('clients.email', 'like', $request->filter['email'].'%');
        // if ($request->has('filter.country.value') && $request->filter['country']['value'] != '') $queryTransaction->where('clients.kato_id', $request->filter['country']['value']);
        
        if ($auth_role === 4 or $auth_role === 5) {
            $hotel = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();
            $queryTransaction->where('transactions.hotel_id', $hotel->id);
        }
        if ($auth_role === 1 or $auth_role === 2 or $auth_role === 3) {
            $queryTransaction->leftJoin('hotels', function($join) {
                $join->on('transactions.hotel_id', 'hotels.id');
            });

            if ($request->has('filter.region.value')) $queryTransaction->where('hotels.region_id', $request->filter['region']['value']);

            if ($request->has('filter.search_hotel_name') && $request->filter['search_hotel_name'] != '') $queryTransaction->where('hotels.name', 'like', $request->filter['search_hotel_name'].'%');
            if ($request->has('filter.search_hotel_bin') && $request->filter['search_hotel_bin'] != '') $queryTransaction->where('hotels.BIN', 'like', $request->filter['search_hotel_bin'].'%');

        }

        if ($request->filter['list'] === 1) {
            $queryTransaction->whereDate('transactions.check_in', '>', Carbon::now());
        }
        // if ($request->filter['list'] === 2) {
        //     $queryTransaction->where('transactions.hotel_id', $hotel->id);
        // }
        if ($request->filter['list'] === 3) {
            $queryTransaction->where('transactions.statuses_id',2);
        }
        if ($request->filter['list'] === 4) {
            $queryTransaction->where('transactions.statuses_id',3);
        }

        if ($request->desc == true) $sort = 'desc';

        else $sort = 'asc';

        // TODO: Необходимо сделать список $request->sort_by
        if ($request->sort_by && $request->sort_by != '') {
            $queryTransaction->orderBy('transactions.' . $request->sort_by, $sort);
        }
        else {
            $queryTransaction->orderBy('transactions.id', $sort);
        }

        $result = $queryTransaction->paginate($request->per_page);

        // return response()->json($result);
        return TransactionResource::collection($result);

        // exit;#######################################

        // if ($request->desc == true) {
        //     $sort = 'desc';
        // } else {
        //     $sort = 'asc';
        // }   

        // // $auth_role = Auth::user()->with('roles')->first()->roles->first()->id;
        // $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        // $auth_role = $user[0]->role_id;
        
        // if ($auth_role === 4 or $auth_role === 5) {
            
        //     $hotel_id = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();
        //     $result = Transaction::query();
            
        //     $result->where('hotel_id', $hotel_id->id);

        //     if ($request->has('filter.check_in_date_from') && $request->filter['check_in_date_from'] != '') $result->where('check_in', '>=', str_replace("/", "-", $request->filter['check_in_date_from']).' 00:00:00');
        //     if ($request->has('filter.check_in_date_to') && $request->filter['check_in_date_to'] != '') $result->where('check_in', '<=', str_replace("/", "-", $request->filter['check_in_date_to']).' 23:59:59');

        //     if ($request->has('filter.check_out_date_from') && $request->filter['check_out_date_from'] != '') $result->where('check_out', '>=', str_replace("/", "-", $request->filter['check_out_date_from']).' 00:00:00');
        //     if ($request->has('filter.check_out_date_to') && $request->filter['check_out_date_to'] != '') $result->where('check_out', '<=', str_replace("/", "-", $request->filter['check_out_date_to']).' 23:59:59');

        //     // $result->whereHas('client', function($q) use($request) {
        //         if ($request->has('filter.surname') && $request->filter['surname'] != '') $result->where('surname', 'like', $request->filter['surname'].'%');
        //         if ($request->has('filter.name') && $request->filter['name'] != '') $result->where('name', 'like', $request->filter['name'].'%');
        //         if ($request->has('filter.document_number') && $request->filter['document_number'] != '') $result->where('document_number', 'like', $request->filter['document_number'].'%');
        //         if ($request->has('filter.phone') && $request->filter['phone'] != '') $result->where('phone', 'like', $request->filter['phone'].'%');
        //         if ($request->has('filter.email') && $request->filter['email'] != '') $result->where('email', 'like', $request->filter['email'].'%');
        //         if ($request->has('filter.country.value') && $request->filter['country']['value'] != '') $result->where('kato_id', $request->filter['country']['value']);
        //     // });

        //     $result->with('client.Citizenship');
            
        //     if ($request->filter['list'] === 1) {
        //         $result->whereDate('check_in', '>', Carbon::now());
        //     }
        //     if ($request->filter['list'] === 2) {
                
        //         $result->whereDate('check_out', '<', Carbon::now() && 'check_out', '>', Carbon::now()  );
                
        //     }
        //     if ($request->filter['list'] === 3) {
        //         // $result->whereDate('check_in', '<=', Carbon::now());
        //         // $result->whereDate('check_out', '>', Carbon::now());

        //         $result->where('statuses_id', 2);
                
        //     }
        //     if ($request->filter['list'] === 4) {
        //         // var_dump("there");
        //         // exit;
        //         $result->where('statuses_id', 3);
        //         // $result->whereDate('check_out', '<=', Carbon::now())->update(['statuses_id'=>3]);
               
        //     }

        //     // TODO: Необходимо сделать список $request->sort_by
        //     if ($request->sort_by && $request->sort_by != '') {
        //         $result->orderBy($request->sort_by, $sort);
        //     }
            
        //     $result = $result->paginate($request->per_page);
        //     return TransactionResource::collection($result);
        // }
        // elseif ($auth_role === 1 or $auth_role === 2 or $auth_role === 3) {
         
        //     $result = Transaction::query();

        //     if ($request->has('filter.check_in_date_from') && $request->filter['check_in_date_from'] != '') $result->where('check_in', '>=', str_replace("/", "-", $request->filter['check_in_date_from']).' 00:00:00');
        //     if ($request->has('filter.check_in_date_to') && $request->filter['check_in_date_to'] != '') $result->where('check_in', '<=', str_replace("/", "-", $request->filter['check_in_date_to']).' 23:59:59');

        //     if ($request->has('filter.check_out_date_from') && $request->filter['check_out_date_from'] != '') $result->where('check_out', '>=', str_replace("/", "-", $request->filter['check_out_date_from']).' 00:00:00');
        //     if ($request->has('filter.check_out_date_to') && $request->filter['check_out_date_to'] != '') $result->where('check_out', '<=', str_replace("/", "-", $request->filter['check_out_date_to']).' 23:59:59');

        //     $result->whereHas('client', function($q) use($request){
        //         if ($request->has('filter.surname') && $request->filter['surname'] != '') $q->where('surname', 'like', '%'.$request->filter['surname'].'%');
        //         if ($request->has('filter.name') && $request->filter['name'] != '') $q->where('name', 'like', '%'.$request->filter['name'].'%');
        //         if ($request->has('filter.document_number') && $request->filter['document_number'] != '') $q->where('document_number', 'like', '%'.$request->filter['document_number'].'%');
        //         if ($request->has('filter.phone') && $request->filter['phone'] != '') $q->where('phone', 'like', '%'.$request->filter['phone'].'%');
        //         if ($request->has('filter.email') && $request->filter['email'] != '') $q->where('email', 'like', '%'.$request->filter['email'].'%');
        //         if ($request->has('filter.country.value') && $request->filter['country']['value'] != '') $q->where('kato_id', $request->filter['country']['value']);
        //     });

        //     $result->with('client.Citizenship');
        //     if ($request->filter['list'] === 1) {
        //         $result->whereDate('check_in', '>', Carbon::now());
        //     }
        //     if ($request->filter['list'] === 2) {
        //         $result->whereDate('check_out', '>', Carbon::now());
        //     }
        //     if ($request->filter['list'] === 3) {
        //         $result->whereDate('check_in', '<=', Carbon::now());
        //         $result->whereDate('check_out', '>', Carbon::now());
        //     }
        //     if ($request->filter['list'] === 4) {
        //         $result->whereDate('check_out', '<', Carbon::now());
        //     }
        //     // TODO: Необходимо сделать список $request->sort_by
        //     if ($request->sort_by && $request->sort_by != '') {
        //         $result->orderBy($request->sort_by, $sort);
        //     }
        //     $result = $result->paginate($request->per_page);
        //     return TransactionResource::collection($result);
        // }

    }

    public function show_client(Request $request)
    {
        $hotel_id = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();

        $result = Client::query()
            ->where('id', '=', $request->id)
            ->where('hotel_id', '=', $hotel_id->id)
            ->with('transactions')
            ->with('Citizenship')
            ->with('gender')
            ->with('doctype')
//            ->whereHas('transactions', function ($q) use ($hotel_id) {
//                $q->where('hotel_id', '=', $hotel_id->id);
//            })
            ->withCount('transactions')
            ->firstOrFail();
        return new ShowClientResource($result);
//        return response()->json($result, 200);
    }

    public function show(Request $request)
    {
        $hotel_id = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();
        $result = Transaction::query()
            ->where('hotel_id', '=', $hotel_id->id)
            ->with('client')
            ->with('client.Citizenship')
            ->with('client.gender')
            ->with('client.doctype')
            ->with('client.target')
            ->with('status')
            ->findOrFail($request->id);
        return new ShowTransactionEditingResource($result);
        return response()->json($result, 200);
    }

    public function update(Request $request)
    {
        $find = Transaction::query()->findOrFail($request->id);
        $find->statuses_id = $request->status;
        $find->number = $request->number;
        $find->comment = $request->comment;
        $find->start_check_date = $request->start_check_date;
        $find->end_check_date = $request->end_check_date;
        $find->check_in = Carbon::parse($request->check_in . ' ' . $request->check_in_time);
        $find->check_out = Carbon::parse($request->check_out . ' ' . $request->check_out_time);
        $find->save();
        $findClient = Client::query()->findOrFail($find->client_id);
        $findClient->surname = $request->surname;
        $findClient->name = $request->name;
        $findClient->patronymic = $request->patronymic;
        $findClient->date_birth = $request->date_birth;
        $findClient->gender_id = $request->gender_id;
        $findClient->doctype_id = $request->doctype_id;
        $findClient->series_documents = $request->series_documents;
        $findClient->document_number = $request->document_number;
        $findClient->valid_until = $request->valid_until;
        $findClient->date_issue = $request->date_issue;
        $findClient->email = $request->email;
        $findClient->phone = $request->phone;
        $findClient->kato_id = $request->kato_id;
        $findClient->save();
        return response()->json('Сохранено', 200);
    }

    public function list_client(Request $request)
    {
        if ($request->desc == true) {
            $sort = 'desc';
        } else {
            $sort = 'asc';
        }
        // $auth_role = Auth::user()->with('roles')->first()->roles->first()->id;

        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;


        if ($auth_role === 4 or $auth_role === 5) {
            $hotel_id = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();
            $result = Client::query();
            $result->where('hotel_id', $hotel_id->id);
            $result->with('Citizenship');
            $result->with('transactions');
            $result->orderBy($request->sort_by, $sort);
            $result = $result->paginate($request->per_page);
            return ShowClientResource::collection($result);
        }
        elseif ($auth_role === 1 or $auth_role === 2 or $auth_role === 3) {
            $result = Client::query();
            $result->with('Citizenship');
            $result->with('transactions');
            $result->orderBy($request->sort_by, $sort);
            $result = $result->paginate($request->per_page);
            return ShowClientResource::collection($result);
        }

    }
    // this.$axios({
    //     url: process.env.API_BACK_END + process.env.API_VERSION + 'registry/client/list/export',
    //     method: 'GET',
    //     responseType: 'blob', // important
    //   }).then((response) => {
    //     const url = window.URL.createObjectURL(new Blob([response.data]));
    //     const link = document.createElement('a');
    //     link.href = url;
    //     link.setAttribute('download', 'export.xlsx');
    //     document.body.appendChild(link);
    //     link.click();
    //   });

    public function exportClient(Request $request)
    {

        // $header is an array containing column headers
        // $header = array("Customer Number", "Customer Name", "Address", "City", "State", "Zip");
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // \Auth::user()->id

        // $hotelId = \App\Models\User::query()->where('id', \Auth::user()->id)->with('responsible')->first()->responsible->first();
        $result = Client::query();

        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUserList = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->get();

            $hotels = [];

            foreach ($hotelUserList as $hotelUser) {
                $hotels[] = $hotelUser->hotel_id;
            }

            $result->where('hotel_id', $hotels);
        }

        $result->with('Citizenship');
        // $result->with('transactions');
        // $result->orderBy($request->sort_by, $sort);
        // $result = $result->paginate($request->per_page);

        // $data = array(
        //     array("age", "name", "gender"),
        //     array("12", "alexander", "male"),
        //     array("18", "shine", "female"),
        // );
        // header('Access-Control-Allow-Origin: *'); // TEMP
        // dd($result->get()->toArray());

        $header = [];
        $data = [];
        $rows = $result->get()->toArray();

        foreach($rows as $key => $row) {
            foreach ($row as $column => $value) {
                if ($key == 0) {
                    $header[] = $column;
                }
                if ($column == 'citizenship') {
                    $data[$key][] = $value['name_eng'];
                }
                else {
                    $data[$key][] = $value;
                }
            }
        }

        // dd($data); exit;

        // Write the data into the new spreadsheet starting at cell A1
        $sheet->fromArray([$header], NULL, 'A1');
        $sheet->fromArray($data, NULL, 'A2');
        // $sheet->fromArray($data, NULL, 'A2');

         header('Access-Control-Allow-Origin: ' . getenv('APP_ALLOW_CORS')); // TEMP - PROD
//        header('Access-Control-Allow-Origin: https://localhost:8081'); // TEMP
        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'); // TEMP

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        // if ($request->desc == true) {
        //     $sort = 'desc';
        // } else {
        //     $sort = 'asc';
        // }

        // $hotel_id = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();
        // $result = Client::query();
        // $result->where('hotel_id', $hotel_id->id);
        // $result->with('Citizenship');
        // $result->with('transactions');
        // $result->orderBy($request->sort_by, $sort);
        // $result = $result->paginate($request->per_page);
        // return ShowClientResource::collection($result);
    }

    public function notif(Request $request)
    {
        $queryNotify = \App\Models\NotifyMvd::query()->select('notify_mvds.*');
        
        $queryNotify->leftJoin('transactions', function($join) {
            $join->on('notify_mvds.transaction_id', 'transactions.id');
        });

        $user = \App\Models\User::where('id', Auth::user()->id)
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        if ($role_id === 4 || $role_id === 5) {
            $hotelUserList = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->get();

            $hotels = [];

            foreach ($hotelUserList as $hotelUser) {
                $hotels[] = $hotelUser->hotel_id;
            }

            $queryNotify->where('transactions.hotel_id', $hotels);
        }

        if (isset($request->filter['send'])) {
            if ($request->filter['send'] == 1) {
                $queryNotify->where('notify_mvds.status', 'completed');
            }
        }

        $queryNotify->orderBy('notify_mvds.' . $request->sort_by, ($request->desc == true) ? 'desc' : 'asc');

        $queryNotify = $queryNotify->paginate($request->per_page);

        return NotifyMvdResource::collection($queryNotify);
        // return response()->json($queryNotify);
     
//         // $hotel_id = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();
//         $result = Transaction::query();
//         if (isset($request->filter['status'])) {
//             $result->where('statuses_id', $request->filter['status']);
//         }
//         if (isset($request->filter['send'])) {
//             if ($request->filter['send'] == 1) {
//                 $result->whereIn('notification_on_mvd',['2','3']);
//             }
//         }
//         // $result->where('hotel_id', $hotel_id->id);
//         $result->with('client');
//         $result->with('hotel');
//         $result->with('hotel.region');
//         $result->with('hotel.area');
//         $result->with('hotel.locality');
// //            ->with('status')
//         $result->with('client.Citizenship');
//         $result->with('client.target');
//         $result->orderBy($request->sort_by, $sort);
//         $result = $result->paginate($request->per_page);
//         return TransactionResource::collection($result);
    }

    public function migration(Request $request) {
        if ($request->desc == 'true') {
            $sort = 'desc';
        } else {
            $sort = 'asc';
        }

        $result = Country::query();
        $result->orderBy($request->sort_by, $sort);
        $result = $result->paginate($request->per_page);

        return MigrationResource::collection($result);
        return response()->json($result, 200);
    }

    public function migrationHandbookShow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $country = Country::findOrFail($request->id);

        return response()->json($country, 200);
    }

    public function migrationHandbookUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'         => 'required',
            'vmp_id'     => 'required',
            'code'       => 'required',
            'vmpVisible' => 'required',
            'name_kaz'   => 'required',
            'name_rus'   => 'required',
            'name_eng'   => 'required',
            'country_code'  => 'required',
            'visa_required' => 'required',
            'max_period_registration' => 'required',
            'allowed_days_without_registration' => 'required',
            'comments' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $country = Country::findOrFail($request->id);
        $country->fill($request->all());

        $country->save();

        return $country;
    }
}
