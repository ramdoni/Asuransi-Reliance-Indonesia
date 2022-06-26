<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;

class ArController extends Controller
{
    public function others()
    {
        $data = Income::orderBy('id','desc')->where(['is_others'=>1,'status'=>1]);
        
        if(isset($_GET['term'])) $data = $data->where(function($table){
                                        $table->where('payment_amount','LIKE', "%{$_GET['term']}%")
                                        ->orWhere('reference_no','LIKE',"%{$_GET['term']}%");
                                    });

        $temp = [];
        foreach($data->offset(0)->limit(10)->get() as $k => $item){
            $temp[$k] = $item;
            $temp[$k]['nominal'] = format_idr($item->payment_amount);
        }
        return response()->json($temp, 200);
    }
}