<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Client;

class AgeController extends Controller
{

	public function calculate_age($date_birth) 
	{
		$birthday_timestamp = strtotime($date_birth);

		$age = date('Y') - date('Y', $birthday_timestamp);

		if (date('md', $birthday_timestamp) > date('md')) $age--;

		return $age;
	}

    public function index()
    {
    	$years = Client::select('date_birth')->orderBy('date_birth')->get();

    	$data = [];

    	if (count($years) > 0) {

    		$ages = [];

    		foreach ($years as $year) {
    			$ages[] = $this->calculate_age($year->date_birth);
    		}

    		$ages = array_unique($ages);

    		$data = [];

    		$i = 0;

    		foreach ($ages as $age) {
    			$data[$i]['label'] = $age;
    			$data[$i]['value'] = $age;

    			$i++;
    		}
    	}

    	return response()->json($data, 200);
    }
}
