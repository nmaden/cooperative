<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transaction;

class YearController extends Controller
{
    public function index()
    {
    	$years = Transaction::orderBy('check_in')->get();

    	$data = [];

    	if (count($years) > 0) {
    		foreach ($years as $key => $value) {
    			$data[] = mb_substr($value->check_in, 0, 4);
    		}

    		$years = array_unique($data);

    		$data = [];

    		$i = 0;

    		foreach ($years as $key => $value) {
    			$data[$i]['label'] = $value;
    			$data[$i]['value'] = $value;

    			$i++;
    		}

    	}

    	return response()->json($data, 200);
    }
}
