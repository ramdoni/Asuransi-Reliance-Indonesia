<?php

function get_group_cashflow($key="")
{
    $data = [1=>'Operation Activities',2=>'Investment Activities',3=>'Financing Activities'];
    if($key!="") return @$data[$key];
    
    return $data;
}

function generate_no_voucher($coa_id)
{
    $coa = \App\Models\Coa::find($coa_id);
    $count = \App\Models\Journal::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->count()+1;
    
    if($coa) return $coa->code_voucher.'-'.str_pad($count,3, '0', STR_PAD_LEFT).'/'.date('m').'/'.date('Y');

    return '';
}

function format_idr($number)
{
    return number_format($number,0,0,'.');
}

function get_setting($key)
{
    $setting = \App\Models\Settings::where('key',$key)->first();

    if($setting)
    {
        if($key=='logo' || $key=='favicon' ){
            return  asset("storage/{$setting->value}");
        }

        return $setting->value;
    }
}

function update_setting($key,$value)
{
    $setting = \App\Models\Settings::where('key',$key)->first();
    if($setting){
        $setting->value = $value;
        $setting->save();
    }else{
        $setting = new \App\Models\Settings();
        $setting->key = $key;
        $setting->value = $value;
        $setting->save();
    }
}