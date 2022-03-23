<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;

class ReinsuranceController extends Controller
{
    public function data()
    {
        $data = Income::select('income.*')->where('reference_type','Reinsurance Commision')
                        //->where('status',1)
                        ->orderBy('income.id','DESC')
                        ->join('policys','policys.id','=','income.policy_id');
        if(isset($_GET['term']))$data->where(function($table){
                $table->where('reference_no','LIKE',"%{$_GET['term']}%")
                        ->orWhere('client','LIKE',"%{$_GET['term']}%")
                        ->orWhere('no_polis','LIKE',"%{$_GET['term']}%");
            });
        return response()->json($data->offset(0)->limit(10)->get(), 200);
    }
}