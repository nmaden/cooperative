<?php


namespace App\Http\Controllers\Api\v1;

use App\PayTransaction;

use Illuminate\Http\Request;

class PayTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = DB::table('model_has_roles')->where('model_id', Auth::id())->get();
        $auth_role = $user[0]->role_id;
        
        if($auth_role==1) {
            return PayTransaction::getAll();
        }
        if($auth_role==5) {
            return PayTransaction::where('client_id',$request->client_id)->get();
        }
        else {
                return response()->json(['error' => 'У вас нет полномочий'], 200);
        }    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PayTransaction  $payTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(PayTransaction $payTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PayTransaction  $payTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(PayTransaction $payTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PayTransaction  $payTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PayTransaction $payTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PayTransaction  $payTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayTransaction $payTransaction)
    {
        //
    }
}
