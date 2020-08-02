<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\DB;
class LogsController extends Controller
{
    public function index(Request $request)
    {

        $user = \App\Models\User::where('id', Auth::id())
        ->with('roles')
        ->with('responsible')
        ->first();

        $role_id = $user->roles[0]->id;

        if($role_id==4 || $role_id==5 ) {
            $LoggedActivity = Activity::all();
            

            $data = [
                'type' => '',
                'time' => '',
                'date' => '',
                'description'> ''
            ];
            $array = [];

            $hotel_id = $request->id;


            for ($i=0; $i <sizeof($LoggedActivity); $i++) { 
                $first = explode(' ',$LoggedActivity[$i]->created_at);

                $time = intval(substr($first[1],0,2));
                
                if($time<19) {
                    $time = $time +5;
                 strlen((string)$time);
                    if( strlen((string)$time)<2) {
                        $time = '0'.$time;
                    }
                }
                else if ($time==19) {
                    $time = '00';
                }
                else if ($time>19 && $time<=23) {
                    $time = $time - 19;
                    $time = '0'.$time;
                }

                $result_time = $time.''.substr($first[1],2,3);
                // return response()->json($LoggedActivity[$i]->properties, 200);
                if ($LoggedActivity[$i]->log_name=='transaction' && isset($LoggedActivity[$i]->properties['attributes']["hotel_id"]) && $LoggedActivity[$i]->properties['attributes']["hotel_id"]==$hotel_id) {
                    $data["type"] = $LoggedActivity[$i]->log_name;
                    $data["date"] = $first[0];
                    $data["time"] = $result_time;
                    
                    $data["description"] = $LoggedActivity[$i]->description.' <<Заезд '.$LoggedActivity[$i]->properties['attributes']["check_in"].' '.' Выезд '.$LoggedActivity[$i]->properties['attributes']["check_out"].'>>';
              
                    array_push($array,$data);
                }  
            }

            
            return response()->json($array, 200);
            // $hotelUser = DB::table('hotel_user')
            // ->where('user_id', Auth::id())
            // ->first();


            // if($lastLoggedActivity->log_name=='transaction') {
                
            
            //     // return $lastLoggedActivity->created_at.' '.$lastLoggedActivity->description.' <<Заезд '.$lastLoggedActivity->properties['attributes']["check_in"].'  Выезд '.$lastLoggedActivity->properties['attributes']["check_out"].'>>';
    
            //     return response()->json([
            //         'time' => $lastLoggedActivity->created_at,
            //         'description' => $lastLoggedActivity->description.' <<Заезд '.$lastLoggedActivity->properties['attributes']["check_in"].'  Выезд '.$lastLoggedActivity->properties['attributes']["check_out"].'>>'
            //     ], 200);
            // }
           
        }
     
    }
}
