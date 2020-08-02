<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Kato;
use App\Models\Status;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AnalyticController extends Controller
{
    public function tour(Request $request)
    {
        $user = User::where('id', Auth::id())
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        $transactionQuery = Transaction::select('transactions.*');
        
        $transactionQuery->leftJoin('clients', function($join) {
            $join->on('transactions.client_id', 'clients.id');
        });

        $hotels = [];

        if ($role_id === 4 || $role_id === 5) {
            $hotelUserList = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->limit(3)
                ->get();

            foreach ($hotelUserList as $hotelUser) {
                $hotels[] = $hotelUser->hotel_id;
            }

            $transactionQuery->whereIn('transactions.hotel_id', $hotels);
        }
        if ($role_id === 1 || $role_id === 2 || $role_id === 3) {
            if ($request->has('filter.hotel') && !empty($request->filter['hotel'])) {
                for ($i = 0; $i < count($request->filter['hotel']) && $i < 3; $i++) {
                    $hotels[] = $request->filter['hotel'][$i]['value'];
                }
            }
            else {
                $topHotels = Transaction::select('hotel_id')
                    ->groupBy('hotel_id')
                    ->orderByDesc(DB::raw('COUNT(hotel_id)'))
                    ->limit(3)
                    ->get();

                foreach ($topHotels as $hotel) {
                    $hotels[] = $hotel->hotel_id;
                }
            }

            $transactionQuery->whereIn('transactions.hotel_id', $hotels);
        }

        if ($request->has('filter.quarter')) {
            if ($request->filter['quarter'] == 1) $transactionQuery->whereMonth('transactions.check_in', '>', 0)->whereMonth('transactions.check_in', '<', 4);
            if ($request->filter['quarter'] == 2) $transactionQuery->whereMonth('transactions.check_in', '>', 3)->whereMonth('transactions.check_in', '<', 7);
            if ($request->filter['quarter'] == 3) $transactionQuery->whereMonth('transactions.check_in', '>', 6)->whereMonth('transactions.check_in', '<', 10);
            if ($request->filter['quarter'] == 4) $transactionQuery->whereMonth('transactions.check_in', '>', 9)->whereMonth('transactions.check_in', '<', 13);
        }

        if ($request->has('filter.year.value')) $transactionQuery->whereYear('transactions.check_in', $request->filter['year']['value']);


        if ($request->has('filter.age_from.value')) {
            $age = $request->filter['age_from']['value'];
            $currentYear = date('Y');
            $dateBirth = $currentYear - $age;
            $transactionQuery->whereDate('clients.date_birth', '<', $dateBirth.'-'.date('m-d'));
        }
        if ($request->has('filter.age_to.value')) {
            $age = $request->filter['age_to']['value'];
            $currentYear = date('Y');
            $dateBirth = $currentYear - $age;
            $transactionQuery->whereDate('clients.date_birth', '>', $dateBirth.'-01-01');
        }

        $result = [];
        $transactionQueryStatus1 = clone $transactionQuery;
        $transactionQueryStatus2 = clone $transactionQuery;
        $transactionQueryStatus3 = clone $transactionQuery;
        $transactionQueryTotal = clone $transactionQuery;
        $result['status']['Заезд']      = $transactionQueryStatus1->where('statuses_id', 1)->count();
        $result['status']['Проживание'] = $transactionQueryStatus2->where('statuses_id', 2)->count();
        $result['status']['Выезд']      = $transactionQueryStatus3->where('statuses_id', 3)->count();
        $result['count_reservation']['arriving']      = '-';
        // $result['count_reservation']['arriving']      = $transactionQueryTotal->count();

        $month = ['Январь', 'Февраль ', 'Март', 'Апрель', 'Май', 'Июнь ', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        $countTouristsInMonth = [];

        foreach ($month as $key => $item) {

            $monthTransaction = clone $transactionQuery;

            $monthTransaction->whereMonth('check_in', $key + 1)->count();

            $countTouristsInMonth[$key] = $monthTransaction->count();
        }

        $result['count_tourists_in_month']['labels'] = $month;
        $result['count_tourists_in_month']['datasets']['0']['label'] = 'Туристы';
        $result['count_tourists_in_month']['datasets']['0']['borderColor'] = '#42A4FF';
        $result['count_tourists_in_month']['datasets']['0']['backgroundColor'] = 'transparent';
        $result['count_tourists_in_month']['datasets']['0']['data'] = $countTouristsInMonth;

        if ($request->has('filter.check_in_date_from') && $request->input('filter.check_in_date_from') != '') $transactionQuery->where('transactions.check_in', '>=', str_replace("/", "-", $request->filter['check_in_date_from']).' 00:00:00');
        if ($request->has('filter.check_in_date_to') && $request->input('filter.check_in_date_to') != '') $transactionQuery->where('transactions.check_in', '<=', str_replace("/", "-", $request->filter['check_in_date_to']).' 23:59:59');
        /*  Количество туристов по месяцам в местах размещений по выбору  */       

        $count_tourists_in_month_in_hotels = [
            '0' => '0',
            '1' => '0',
            '2' => '0',
            '3' => '0',
            '4' => '0',
            '5' => '0',
            '6' => '0',
            '7' => '0',
            '8' => '0',
            '9' => '0',
            '10' => '0',
            '11' => '0',
        ];

        foreach ($hotels as $key => $hotelId) {
            $transactionQueryHotel = clone $transactionQuery;
            $transactionQueryHotel->where('transactions.hotel_id', $hotelId);

            $hotel = Hotel::where('id', $hotelId)->first();

            if (!$hotel) continue; // if client send wrong id

            foreach ($transactionQueryHotel->get() as $transaction) {
                $check_in = Carbon::parse($transaction->check_in)->month;
                $check_out = Carbon::parse($transaction->check_out)->month;

                $count_tourists_in_month_in_hotels[$check_in - 1]++;
            }

            $result['count_tourists_in_month_in_hotels']['datasets'][$key]['label'] = $hotel->name; // $transaction->hotel->name; 
            $result['count_tourists_in_month_in_hotels']['datasets'][$key]['data'] = $count_tourists_in_month_in_hotels;
            $result['count_tourists_in_month_in_hotels']['datasets'][$key]['backgroundColor'] = 'transparent';

            $count_tourists_in_month_in_hotels = [
                '0' => '0',
                '1' => '0',
                '2' => '0',
                '3' => '0',
                '4' => '0',
                '5' => '0',
                '6' => '0',
                '7' => '0',
                '8' => '0',
                '9' => '0',
                '10' => '0',
                '11' => '0',
            ];
        }
        $result['count_tourists_in_month_in_hotels']['labels'] = $month;

        if (!isset($result['count_tourists_in_month_in_hotels']['datasets'])) {
            $result['count_tourists_in_month_in_hotels']['datasets'][0]['label'] = 'Нет данных';
        }
        if (isset($result['count_tourists_in_month_in_hotels']['datasets']['0'])) {
            $result['count_tourists_in_month_in_hotels']['datasets']['0']['borderColor'] = '#42A4FF';
        }
        if (isset($result['count_tourists_in_month_in_hotels']['datasets']['1'])) {
            $result['count_tourists_in_month_in_hotels']['datasets']['1']['borderColor'] = '#FF0000';
        }
        if (isset($result['count_tourists_in_month_in_hotels']['datasets']['2'])) {
            $result['count_tourists_in_month_in_hotels']['datasets']['2']['borderColor'] = '#0000FF';
        }


        return response()->json($result, 200);
        // exit; #################################

        // $user = User::where('id', Auth::id())
        //     ->with('roles')
        //     ->with('responsible')
        //     ->first();

        // $role_id = $user->roles[0]->id;

        // if ($role_id === 1 || $role_id === 2 || $role_id === 3) {
        //     $result_statistics = Transaction::query();

        //     if ($request->has('filter.hotel') && $request->has('filter.hotel.0.value')) {
        //         $hotels = [];

        //         foreach ($request->filter['hotel'] as $hotel) {
        //             $hotels[] = $hotel['value'];
        //         }

        //         $result_statistics->whereIn('transactions.hotel_id', $hotels);
        //     }

        //     if ($request->has('filter.year.value')) $result_statistics->whereYear('check_in', $request->filter['year']['value']);
        //     if ($request->has('filter.quarter')) {
        //         if ($request->filter['quarter'] == 1) $result_statistics->whereMonth('check_in', '>', 0)->whereMonth('check_in', '<', 4);
        //         if ($request->filter['quarter'] == 2) $result_statistics->whereMonth('check_in', '>', 3)->whereMonth('check_in', '<', 7);
        //         if ($request->filter['quarter'] == 3) $result_statistics->whereMonth('check_in', '>', 6)->whereMonth('check_in', '<', 10);
        //         if ($request->filter['quarter'] == 4) $result_statistics->whereMonth('check_in', '>', 9)->whereMonth('check_in', '<', 13);
        //     }

        //     if ($request->has('filter.check_in_date_from')) $result_statistics->where('check_in', '>=', str_replace("/", "-", $request->filter['check_in_date_from']).' 00:00:00');
        //     if ($request->has('filter.check_in_date_to')) $result_statistics->where('check_in', '<=', str_replace("/", "-", $request->filter['check_in_date_to']).' 23:59:59');

        //     $result_statistics->join('clients', function ($join) use($request){
        //         $join->on('clients.id', '=', 'transactions.client_id');

        //         if ($request->has('filter.age.value')) {

        //             $age = $request->filter['age']['value'];

        //             $current_year = date('Y');

        //             $date_birth = $current_year - $age;

        //             $join->whereDate('date_birth', '>', $date_birth.'-01-01')->whereDate('date_birth', '<', $date_birth.'-'.date('m-d'));
        //         }

        //     });

        //     $result['status']['Заезд']      = $result_statistics->where('statuses_id', 1)->count();
        //     $result['status']['Проживание'] = $result_statistics->where('statuses_id', 2)->count();
        //     $result['status']['Выезд']      = $result_statistics->where('statuses_id', 3)->count();

        //     //

        //     $month = ['Январь', 'Февраль ', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        //     $count_tourists_in_month = Transaction::all();

        //     foreach ($month as $key => $item) {

        //         $result_transaction = Transaction::query();

        //         if ($request->has('filter.hotel') && $request->has('filter.hotel.0.value')) $result_transaction->whereIn('transactions.hotel_id', $hotels);

        //         $result_transaction->whereMonth('check_in', $key + 1)->count();

        //         if ($request->has('filter.year.value')) $result_transaction->whereYear('check_in', $request->filter['year']['value']);
        //         if ($request->has('filter.quarter')) {
        //             if ($request->filter['quarter'] == 1) $result_transaction->whereMonth('check_in', '>', 0)->whereMonth('check_in', '<', 4);
        //             if ($request->filter['quarter'] == 2) $result_transaction->whereMonth('check_in', '>', 3)->whereMonth('check_in', '<', 7);
        //             if ($request->filter['quarter'] == 3) $result_transaction->whereMonth('check_in', '>', 6)->whereMonth('check_in', '<', 10);
        //             if ($request->filter['quarter'] == 4) $result_transaction->whereMonth('check_in', '>', 9)->whereMonth('check_in', '<', 13);
        //         }

        //         if ($request->has('filter.check_in_date_from')) $result_transaction->where('check_in', '>=', str_replace("/", "-", $request->filter['check_in_date_from']).' 00:00:00');
        //         if ($request->has('filter.check_in_date_to')) $result_transaction->where('check_in', '<=', str_replace("/", "-", $request->filter['check_in_date_to']).' 23:59:59');

        //         $result_transaction->join('clients', function ($join) use($request){
        //             $join->on('clients.id', '=', 'transactions.client_id');

        //             if ($request->has('filter.age.value')) {

        //                 $age = $request->filter['age']['value'];

        //                 $current_year = date('Y');

        //                 $date_birth = $current_year - $age;

        //                 $join->whereDate('date_birth', '>', $date_birth.'-01-01')->whereDate('date_birth', '<', $date_birth.'-'.date('m-d'));
        //             }

        //         });

        //         $count_tourists_in_month[$key] = $result_transaction->count();
        //     }
        // }

        // if ($role_id === 4 || $role_id === 5) {

        //     // $hotel_id = \App\Models\User::query()->where('id', Auth::id())->with('responsible')->first()->responsible->first();

        //     $result_statistics = Transaction::query();

        //     // $result_statistics->where('transactions.hotel_id', $hotel_id->id);

        //     $hotelUserList = DB::table('hotel_user')
        //         ->where('user_id', Auth::user()->id)
        //         ->get();
            
        //     $hotels = [];

        //     foreach ($hotelUserList as $hotelUser) {
        //         $hotels[] = $hotelUser->hotel_id;
        //     }

        //     $result_statistics->whereIn('transactions.hotel_id', $hotels);

        //     if ($request->has('filter.year.value')) $result_statistics->whereYear('check_in', $request->filter['year']['value']);
        //     if ($request->has('filter.quarter')) {
        //         if ($request->filter['quarter'] == 1) $result_statistics->whereMonth('check_in', '>', 0)->whereMonth('check_in', '<', 4);
        //         if ($request->filter['quarter'] == 2) $result_statistics->whereMonth('check_in', '>', 3)->whereMonth('check_in', '<', 7);
        //         if ($request->filter['quarter'] == 3) $result_statistics->whereMonth('check_in', '>', 6)->whereMonth('check_in', '<', 10);
        //         if ($request->filter['quarter'] == 4) $result_statistics->whereMonth('check_in', '>', 9)->whereMonth('check_in', '<', 13);
        //     }

        //     if ($request->has('filter.check_in_date_from')) $result_statistics->where('check_in', '>=', str_replace("/", "-", $request->filter['check_in_date_from']).' 00:00:00');
        //     if ($request->has('filter.check_in_date_to')) $result_statistics->where('check_in', '<=', str_replace("/", "-", $request->filter['check_in_date_to']).' 23:59:59');

        //     $result_statistics->join('clients', function ($join) use($request){
        //         $join->on('clients.id', '=', 'transactions.client_id');

        //         if ($request->has('filter.age.value')) {

        //             $age = $request->filter['age']['value'];

        //             $current_year = date('Y');

        //             $date_birth = $current_year - $age;

        //             $join->whereDate('date_birth', '>', $date_birth.'-01-01')->whereDate('date_birth', '<', $date_birth.'-'.date('m-d'));
        //         }

        //     });

        //     $result['status']['Заезд']      = $result_statistics->where('statuses_id', 1)->count();
        //     $result['status']['Проживание'] = $result_statistics->where('statuses_id', 2)->count();
        //     $result['status']['Выезд']      = $result_statistics->where('statuses_id', 3)->count();

        //     //

        //     $month = ['Январь', 'Февраль ', 'Март', 'Апрель', 'Май', 'Июнь ', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        //     $count_tourists_in_month = Transaction::all();

        //     foreach ($month as $key => $item) {

        //         $result_transaction = Transaction::query();

        //         $result_transaction->where('transactions.hotel_id', $hotels);

        //         //  if ($request->has('filter.hotel') && $request->has('filter.hotel.0.value')) $result_transaction->whereIn('transactions.hotel_id', $hotels);

        //         $result_transaction->whereMonth('check_in', $key + 1)->count();

        //         if ($request->has('filter.year.value')) $result_transaction->whereYear('check_in', $request->filter['year']['value']);
        //         if ($request->has('filter.quarter')) {
        //             if ($request->filter['quarter'] == 1) $result_transaction->whereMonth('check_in', '>', 0)->whereMonth('check_in', '<', 4);
        //             if ($request->filter['quarter'] == 2) $result_transaction->whereMonth('check_in', '>', 3)->whereMonth('check_in', '<', 7);
        //             if ($request->filter['quarter'] == 3) $result_transaction->whereMonth('check_in', '>', 6)->whereMonth('check_in', '<', 10);
        //             if ($request->filter['quarter'] == 4) $result_transaction->whereMonth('check_in', '>', 9)->whereMonth('check_in', '<', 13);
        //         }

        //         if ($request->has('filter.check_in_date_from')) $result_transaction->where('check_in', '>=', str_replace("/", "-", $request->filter['check_in_date_from']).' 00:00:00');
        //         if ($request->has('filter.check_in_date_to')) $result_transaction->where('check_in', '<=', str_replace("/", "-", $request->filter['check_in_date_to']).' 23:59:59');

        //         $result_transaction->join('clients', function ($join) use($request){
        //             $join->on('clients.id', '=', 'transactions.client_id');

        //             if ($request->has('filter.age.value')) {

        //                 $age = $request->filter['age']['value'];

        //                 $current_year = date('Y');

        //                 $date_birth = $current_year - $age;

        //                 $join->whereDate('date_birth', '>', $date_birth.'-01-01')->whereDate('date_birth', '<', $date_birth.'-'.date('m-d'));
        //             }

        //         });

        //         $count_tourists_in_month[$key] = $result_transaction->count();
        //     }
        // }

        // $result['count_tourists_in_month']['labels'] = $month;
        // $result['count_tourists_in_month']['datasets']['0']['label'] = 'Туристы';
        // $result['count_tourists_in_month']['datasets']['0']['borderColor'] = '#42A4FF';
        // $result['count_tourists_in_month']['datasets']['0']['backgroundColor'] = 'transparent';
        // $result['count_tourists_in_month']['datasets']['0']['data'] = $count_tourists_in_month;

        // /*  Регион  */

        // $count_tourists_in_month_in_region = [
        //     '0' => '0',
        //     '1' => '0',
        //     '2' => '0',
        //     '3' => '0',
        //     '4' => '0',
        //     '5' => '0',
        //     '6' => '0',
        //     '7' => '0',
        //     '8' => '0',
        //     '9' => '0',
        //     '10' => '0',
        //     '11' => '0',
        // ];

        // $katos = Kato::query()->has('hotel_region')
        //     ->with('hotel_region')
        //     ->with('hotel_region.Transactions');

        // if ($request->has('filter.region.value')) $katos->where('id', $request->filter['region']['value']);

        // $katos = $katos->get();

        // foreach ($katos as $key => $kato) {
        //     foreach ($kato->hotel_region as $item) {
        //         if ($item->transactions->isNotEmpty()) {
        //             foreach ($item->transactions as $transaction) {
        //                 $check_in = Carbon::parse($transaction->check_in)->month;
        //                 $check_out = Carbon::parse($transaction->check_out)->month;
        //                 for ($i = $check_in; $i <= $check_out; $i++) {
        //                     $count_tourists_in_month_in_region[$i - 1] = $count_tourists_in_month_in_region[$i] + 1;
        //                 }
        //             }
        //         }
        //     }
            
        //     $result['count_tourists_in_month_in_region']['datasets'][$key]['label'] = $kato->name_rus;
        //     $result['count_tourists_in_month_in_region']['datasets'][$key]['data'] = $count_tourists_in_month_in_region;
        //     $result['count_tourists_in_month_in_region']['datasets'][$key]['backgroundColor'] = 'transparent';

        //     $count_tourists_in_month_in_region = [
        //         '0' => '0',
        //         '1' => '0',
        //         '2' => '0',
        //         '3' => '0',
        //         '4' => '0',
        //         '5' => '0',
        //         '6' => '0',
        //         '7' => '0',
        //         '8' => '0',
        //         '9' => '0',
        //         '10' => '0',
        //         '11' => '0',
        //     ];
        // }
        // $result['count_tourists_in_month_in_region']['labels'] = $month;
        // $result['count_tourists_in_month_in_region']['datasets']['0']['borderColor'] = '#42A4FF';

        // /*  Количество туристов по месяцам в местах размещений по выбору  */       

        // $count_tourists_in_month_in_hotels = [
        //     '0' => '0',
        //     '1' => '0',
        //     '2' => '0',
        //     '3' => '0',
        //     '4' => '0',
        //     '5' => '0',
        //     '6' => '0',
        //     '7' => '0',
        //     '8' => '0',
        //     '9' => '0',
        //     '10' => '0',
        //     '11' => '0',
        // ];

        // $hotels = Hotel::query();

        // // $result_transaction->where('transactions.hotel_id', $hotels);
        // $hotel_list = [];
        // if ($role_id === 1 || $role_id === 2 || $role_id === 3) {
        //     if ($request->has('filter.hotel')) {
        //         for ($i = 0; $i < count($request->filter['hotel']); $i++) {
        //             $hotel_list[] = $request->filter['hotel'][$i]['value'];
        //         }
        //     } else {
        //         $top_hotels = Transaction::select('hotel_id')
        //             ->groupBy('hotel_id')
        //             ->orderByDesc(DB::raw('COUNT(hotel_id)'))
        //             ->limit(3)
        //             ->get();

        //         foreach ($top_hotels as $top_hotel) {
        //             $hotel_list[] = $top_hotel->hotel_id;
        //         }
        //     }
        // }
        // if ($role_id === 4 || $role_id === 5) {
        //     $hotelUserList = DB::table('hotel_user')
        //         ->where('user_id', Auth::user()->id)
        //         ->get();

        //     foreach ($hotelUserList as $hotelUser) {
        //         $hotel_list[] = $hotelUser->hotel_id;
        //     }
        // }
        // $hotels = $hotels->whereIn('hotels.id', $hotel_list)
        //     ->has('Transactions')
        //     ->with('Transactions')
        //     ->get();

        // foreach ($hotels as $key => $hotel) {
        //     foreach ($hotel->transactions as $transaction) {
        //         $check_in = Carbon::parse($transaction->check_in)->month;
        //         $check_out = Carbon::parse($transaction->check_out)->month;

        //         $count_tourists_in_month_in_hotels[$check_in - 1]++;
        //     }
        //     $result['count_tourists_in_month_in_hotels']['datasets'][$key]['label'] = $hotel->name;
        //     $result['count_tourists_in_month_in_hotels']['datasets'][$key]['data'] = $count_tourists_in_month_in_hotels;
        //     $result['count_tourists_in_month_in_hotels']['datasets'][$key]['backgroundColor'] = 'transparent';

        //     $count_tourists_in_month_in_hotels = [
        //         '0' => '0',
        //         '1' => '0',
        //         '2' => '0',
        //         '3' => '0',
        //         '4' => '0',
        //         '5' => '0',
        //         '6' => '0',
        //         '7' => '0',
        //         '8' => '0',
        //         '9' => '0',
        //         '10' => '0',
        //         '11' => '0',
        //     ];
        // }
        // $result['count_tourists_in_month_in_hotels']['labels'] = $month;
        // $result['count_tourists_in_month_in_hotels']['datasets']['0']['borderColor'] = '#42A4FF';
        // if (isset($result['count_tourists_in_month_in_hotels']['datasets']['1'])) {
        //     $result['count_tourists_in_month_in_hotels']['datasets']['1']['borderColor'] = '#FF0000';
        // }
        // if (isset($result['count_tourists_in_month_in_hotels']['datasets']['2'])) {
        //     $result['count_tourists_in_month_in_hotels']['datasets']['2']['borderColor'] = '#0000FF';
        // }

        // return response()->json($result, 200);
    }

    public function dashboard(Request $request) {
        $month = ['Январь', 'Февраль ', 'Март', 'Апрель', 'Май', 'Июнь ', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        $transactions_all = Transaction::all();
        $count_tourists_in_month = [
            '0' => '0',
            '1' => '0',
            '2' => '0',
            '3' => '0',
            '4' => '0',
            '5' => '0',
            '6' => '0',
            '7' => '0',
            '8' => '0',
            '9' => '0',
            '10' => '0',
            '11' => '0',
        ];
        foreach ($transactions_all as $item) {
            $check_in = Carbon::parse($item->check_in)->month;
            $check_out = Carbon::parse($item->check_out)->month;
            for ($i = $check_in; $i <= $check_out; $i++) {
                $count_tourists_in_month[$i - 1] = $count_tourists_in_month[$i] + 1;
            }
        }
        $result['count_tourists_in_month']['labels'] = $month;
        $result['count_tourists_in_month']['datasets']['0']['label'] = 'Туристы';
        $result['count_tourists_in_month']['datasets']['0']['borderColor'] = '#42A4FF';
        $result['count_tourists_in_month']['datasets']['0']['backgroundColor'] = 'transparent';
        $result['count_tourists_in_month']['datasets']['0']['data'] = $count_tourists_in_month;

        $client_in_country = Country::query()->has('Clients')->with('Clients')->get();
        $country_labels = $client_in_country->pluck('name_rus');
        $result['tourist_country']['labels'] = $country_labels;
        $color = ['#FF9C07', '#0797FF', '#42A4FF','#FF9C07', '#0797FF', '#42A4FF','#FF9C07', '#0797FF', '#42A4FF','#FF9C07', '#0797FF', '#42A4FF','#FF9C07', '#0797FF', '#42A4FF','#FF9C07', '#0797FF', '#42A4FF',];
        $client_in_country = Country::query()->has('Clients')->with('Clients')->get();
        $country_labels = $client_in_country->pluck('name_rus');
        foreach ($client_in_country as $key => $item) {
            $result['tourist_country']['datasets'][$key]['label'] = $item->name_rus;
            if ($key === 0) {
                $result['tourist_country']['datasets'][$key]['data'][] = $item->clients->count();
            } elseif ($key > 0) {
                for ($i = 1; $i <= $key; $i++) {
                    $result['tourist_country']['datasets'][$key]['data'][] = 0;
                }
                $result['tourist_country']['datasets'][$key]['data'][] = $item->clients->count();
            }
            $result['tourist_country']['datasets'][$key]['backgroundColor'] = $color[$key];
        }
        $result['tourist_country']['labels'] = $country_labels;

        return $result;
    }

    public function portrait(Request $request)
    {
        $user = User::where('id', Auth::id())
            ->with('roles')
            ->with('responsible')
            ->first();

        $role_id = $user->roles[0]->id;

        $transactionQuery = Transaction::select('transactions.*', 'clients.date_birth');
        
        $transactionQuery->leftJoin('clients', function($join) {
            $join->on('transactions.client_id', 'clients.id');
        });

        $hotels = [];

        if ($role_id === 4 || $role_id === 5) {
            $hotelUserList = DB::table('hotel_user')
                ->where('user_id', Auth::user()->id)
                ->limit(3)
                ->get();

            foreach ($hotelUserList as $hotelUser) {
                $hotels[] = $hotelUser->hotel_id;
            }

            $transactionQuery->whereIn('transactions.hotel_id', $hotels);
        }
        if ($role_id === 1 || $role_id === 2 || $role_id === 3) {
            if ($request->has('filter.hotel') && !empty($request->filter['hotel'])) {
                for ($i = 0; $i < count($request->filter['hotel']) && $i < 3; $i++) {
                    $hotels[] = $request->filter['hotel'][$i]['value'];
                }
            }
            else {
                $topHotels = Transaction::select('hotel_id')
                    ->groupBy('hotel_id')
                    ->orderByDesc(DB::raw('COUNT(hotel_id)'))
                    ->limit(3)
                    ->get();

                foreach ($topHotels as $hotel) {
                    $hotels[] = $hotel->hotel_id;
                }
            }

            $transactionQuery->whereIn('transactions.hotel_id', $hotels);
        }

        if ($request->has('filter.check_in_date_from') && $request->input('filter.check_in_date_from') != '') $transactionQuery->where('transactions.check_in', '>=', str_replace("/", "-", $request->filter['check_in_date_from']).' 00:00:00');
        if ($request->has('filter.check_in_date_to') && $request->input('filter.check_in_date_to') != '') $transactionQuery->where('transactions.check_in', '<=', str_replace("/", "-", $request->filter['check_in_date_to']).' 23:59:59');

        if ($request->has('filter.quarter')) {
            if ($request->filter['quarter'] == 1) $transactionQuery->whereMonth('transactions.check_in', '>', 0)->whereMonth('transactions.check_in', '<', 4);
            if ($request->filter['quarter'] == 2) $transactionQuery->whereMonth('transactions.check_in', '>', 3)->whereMonth('transactions.check_in', '<', 7);
            if ($request->filter['quarter'] == 3) $transactionQuery->whereMonth('transactions.check_in', '>', 6)->whereMonth('transactions.check_in', '<', 10);
            if ($request->filter['quarter'] == 4) $transactionQuery->whereMonth('transactions.check_in', '>', 9)->whereMonth('transactions.check_in', '<', 13);
        }

        if ($request->has('filter.year.value')) $transactionQuery->whereYear('transactions.check_in', $request->filter['year']['value']);


        if ($request->has('filter.age_from.value')) {
            $age = $request->filter['age_from']['value'];
            $currentYear = date('Y');
            $dateBirth = $currentYear - $age;
            $transactionQuery->whereDate('clients.date_birth', '<', $dateBirth.'-'.date('m-d'));
        }
        if ($request->has('filter.age_to.value')) {
            $age = $request->filter['age_to']['value'];
            $currentYear = date('Y');
            $dateBirth = $currentYear - $age;
            $transactionQuery->whereDate('clients.date_birth', '>', $dateBirth.'-01-01');
        }

        $result = [];

        $transactionQueryStatus1 = clone $transactionQuery;
        $transactionQueryStatus2 = clone $transactionQuery;
        $transactionQueryStatus3 = clone $transactionQuery;
        $transactionQueryStatus4 = clone $transactionQuery;
        $transactionQueryStatus5 = clone $transactionQuery;
        $transactionQueryStatus6 = clone $transactionQuery;
        $transactionQueryStatus7 = clone $transactionQuery;
        $transactionQueryStatus8 = clone $transactionQuery;
        $transactionQueryStatus9 = clone $transactionQuery;
        $result['status']['Заезд']      = $transactionQueryStatus1->where('transactions.statuses_id', 1)->count();
        $result['status']['Проживание'] = $transactionQueryStatus2->where('transactions.statuses_id', 2)->count();
        $result['status']['Выезд']      = $transactionQueryStatus3->where('transactions.statuses_id', 3)->count();
        $transactionQueryStatus4->leftJoin('katos', function($join) {
            $join->on('clients.kato_id', 'katos.id');
        });
        $result['count_region'] = (string)$transactionQueryStatus4->groupBy('katos.id')->count();
        // $result['count_region'] = (string)$transactionQueryStatus4->where('katos.level', 2)->where('katos.area_type', 0)->count();

        $dateDiff = [];

        foreach ($transactionQueryStatus6->get() as $item) {
            $checkIn = Carbon::parse($item->check_in);
            $checkOut = Carbon::parse($item->check_out);
            $dateDiff[] = $checkIn->diffInDays($checkOut);
        }
        $result['count_days'] = round((array_sum($dateDiff) / count($dateDiff)), 1);

        /*---------------------------------
        |   Портрет туриста по возрасту   |
        ---------------------------------*/
        $ages = $transactionQueryStatus7->get();
        foreach ($ages as $key => $age) {
            $ages[$key]['age'] = Carbon::parse($age->date_birth)->diffInYears();
        }
        $filtered['18-29'] = $ages->where('age', '>=', '18')->where('age', '<=', '29')->count();
        $filtered['30-44'] = $ages->where('age', '>=', '30')->where('age', '<=', '44')->count();
        $filtered['45-60'] = $ages->where('age', '>=', '45')->where('age', '<=', '60')->count();
        $filtered['60'][] = $ages->where('age', '>', '60')->count();
        $result['ages'] = $filtered;

        /*----------------------------------------
        |   Портрет туриста по возрасту и полу   |
        ----------------------------------------*/
        $female = $transactionQueryStatus8->where('clients.gender_id', '=', 1)->get();
        $male = $transactionQueryStatus9->where('clients.gender_id', '=', 2)->get();
        foreach ($male as $key => $mel) {
            $male[$key]['age'] = Carbon::parse($mel->date_birth)->diffInYears();
        }
        $filtered['18-29'] = $male->where('age', '>=', '18')->where('age', '<=', '29')->count();
        $filtered['30-44'] = $male->where('age', '>=', '30')->where('age', '<=', '44')->count();
        $filtered['45-60'] = $male->where('age', '>=', '45')->where('age', '<=', '60')->count();
        $filtered['60'] = $male->where('age', '>', '60')->count();
        $result['gender']['18-29'][] = $filtered['18-29'];
        $result['gender']['30-44'][] = $filtered['30-44'];
        $result['gender']['45-60'][] = $filtered['45-60'];
        $result['gender']['60'][] = $filtered['60'];
        foreach ($female as $key => $fem) {
            $female[$key]['age'] = Carbon::parse($fem->date_birth)->diffInYears();
        }
        $filtered['18-29'] = $female->where('age', '>=', '18')->where('age', '<=', '29')->count();
        $filtered['30-44'] = $female->where('age', '>=', '30')->where('age', '<=', '44')->count();
        $filtered['45-60'] = $female->where('age', '>=', '45')->where('age', '<=', '60')->count();
        $filtered['60'] = $female->where('age', '>', '60')->count();

        $result['gender']['18-29'][] = $filtered['18-29'];
        $result['gender']['30-44'][] = $filtered['30-44'];
        $result['gender']['45-60'][] = $filtered['45-60'];
        $result['gender']['60'][] = $filtered['60'];

        return response()->json($result, 200);
//         exit; #################################
//         $result['status'] = Status::withCount('Transcations')->get()->pluck('transcations_count', 'name');
//         $result['count_region'] = Kato::query()->where('level', 2)->where('area_type', 0)->count();
//         $counts = Transaction::query()->get();
//         foreach ($counts as $item) {
//             $check_in = Carbon::parse($item->check_in);
//             $check_out = Carbon::parse($item->check_out);
//             $date_diff[] = $check_in->diffInDays($check_out);
//         }
//         $result['count_days'] = array_sum($date_diff) / count($date_diff);


// //        Портрет туриста по возрасту

//         $clients = Client::query()->get();
//         $ages = $clients;
//         foreach ($ages as $key => $age) {
//             $ages[$key]['age'] = Carbon::parse($age->date_birth)->diffInYears();
//         }
//         $filtered['18-29'] = $ages->where('age', '>=', '18')->where('age', '<=', '29')->count();
//         $filtered['30-44'] = $ages->where('age', '>=', '30')->where('age', '<=', '44')->count();
//         $filtered['45-60'] = $ages->where('age', '>=', '45')->where('age', '<=', '60')->count();
//         $filtered['60'][] = $ages->where('age', '>', '60')->count();
//         $result['ages'] = $filtered;

// //        Портрет туриста по возрасту и полу
//         $female = Client::query()->where('gender_id', '=', 1)->get();
//         $male = Client::query()->where('gender_id', '=', 2)->get();
//         foreach ($male as $key => $mel) {
//             $male[$key]['age'] = Carbon::parse($mel->date_birth)->diffInYears();
//         }
//         $filtered['18-29'] = $male->where('age', '>=', '18')->where('age', '<=', '29')->count();
//         $filtered['30-44'] = $male->where('age', '>=', '30')->where('age', '<=', '44')->count();
//         $filtered['45-60'] = $male->where('age', '>=', '45')->where('age', '<=', '60')->count();
//         $filtered['60'] = $male->where('age', '>', '60')->count();
//         $result['gender']['18-29'][] = $filtered['18-29'];
//         $result['gender']['30-44'][] = $filtered['30-44'];
//         $result['gender']['45-60'][] = $filtered['45-60'];
//         $result['gender']['60'][] = $filtered['60'];
//         foreach ($female as $key => $fem) {
//             $female[$key]['age'] = Carbon::parse($fem->date_birth)->diffInYears();
//         }
//         $filtered['18-29'] = $female->where('age', '>=', '18')->where('age', '<=', '29')->count();
//         $filtered['30-44'] = $female->where('age', '>=', '30')->where('age', '<=', '44')->count();
//         $filtered['45-60'] = $female->where('age', '>=', '45')->where('age', '<=', '60')->count();
//         $filtered['60'] = $female->where('age', '>', '60')->count();

//         $result['gender']['18-29'][] = $filtered['18-29'];
//         $result['gender']['30-44'][] = $filtered['30-44'];
//         $result['gender']['45-60'][] = $filtered['45-60'];
//         $result['gender']['60'][] = $filtered['60'];

// //      Портрет посетителя в разрезе гражданства

//         /*
//         $color = ['#FF9C07', '#0797FF', '#42A4FF'];
//         $client_in_country = Country::query()->has('Clients')->with('Clients')->get();
//         $country_labels = $client_in_country->pluck('name_rus');
//         foreach ($client_in_country as $key => $item) {
//             $result['tourist_country']['datasets'][$key]['label'] = $item->name_rus;
//             if ($key === 0) {
//                 $result['tourist_country']['datasets'][$key]['data'][] = $item->clients->count();
//             } elseif ($key > 0) {
//                 for ($i = 1; $i <= $key; $i++) {
//                     $result['tourist_country']['datasets'][$key]['data'][] = 0;
//                 }
//                 $result['tourist_country']['datasets'][$key]['data'][] = $item->clients->count();
//             }
//             $result['tourist_country']['datasets'][$key]['backgroundColor'] = $color[$key];
//         }
//         $result['tourist_country']['labels'] = $country_labels;

//         */

//         return $result;
    }

    public function count_tourists_in_month_in_region(Request $request)
    {
        $month = ['Январь', 'Февраль ', 'Март', 'Апрель', 'Май', 'Июнь ', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

        $count_tourists_in_month_in_region = [
            '0' => '0',
            '1' => '0',
            '2' => '0',
            '3' => '0',
            '4' => '0',
            '5' => '0',
            '6' => '0',
            '7' => '0',
            '8' => '0',
            '9' => '0',
            '10' => '0',
            '11' => '0',
        ];

        $katos = Kato::query()->has('hotel_region')
            ->with('hotel_region')
            ->with('hotel_region.Transactions');

        if ($request->has('filter.region.value')) $katos->where('id', $request->filter['region']['value']);

        $katos = $katos->get();

        foreach ($katos as $key => $kato) {
            foreach ($kato->hotel_region as $item) {
                if ($item->transactions->isNotEmpty()) {
                    foreach ($item->transactions as $transaction) {
                        $check_in = Carbon::parse($transaction->check_in)->month;
                        $check_out = Carbon::parse($transaction->check_out)->month;
                        for ($i = $check_in; $i <= $check_out; $i++) {
                            $count_tourists_in_month_in_region[$i - 1] = $count_tourists_in_month_in_region[$i] + 1;
                        }
                    }
                }
            }
            
            $result['count_tourists_in_month_in_region']['datasets'][$key]['label'] = $kato->name_rus;
            $result['count_tourists_in_month_in_region']['datasets'][$key]['data'] = $count_tourists_in_month_in_region;
            $result['count_tourists_in_month_in_region']['datasets'][$key]['backgroundColor'] = 'transparent';

            $count_tourists_in_month_in_region = [
                '0' => '0',
                '1' => '0',
                '2' => '0',
                '3' => '0',
                '4' => '0',
                '5' => '0',
                '6' => '0',
                '7' => '0',
                '8' => '0',
                '9' => '0',
                '10' => '0',
                '11' => '0',
            ];
        }
        $result['count_tourists_in_month_in_region']['labels'] = $month;
        $result['count_tourists_in_month_in_region']['datasets']['0']['borderColor'] = '#42A4FF';

        return $result;
    }

}
