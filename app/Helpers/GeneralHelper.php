<?php

function no_voucher($item)
{
    $flag = " <span class=\"badge badge-info\" title=\"".($item->type==1?'Konven':'Syariah').".\">".($item->type==1?'K':'S')."</span>";

    return $item->no_voucher.$flag;
}

function status_account_balance($status)
{
    switch($status){
        case 1:
            return 'Inhouse Transfer';
        break;
        case 2:
            return "Open Balance";
        break;
        case 3:
            return "Investasi";
        break;
        case 4:
            return "Premium Receivable";
        break;
        case 5:
            return "Reinsurance Premium";
        break;
        case 6:
            return "Claim Payable";
        break;
        case 7:
            return "Refund";
        break;
        case 8:
            return "Cancelation";
        break;
        case 9:
            return "Endorsement Reas";
        break;
    }
}

function calculate_aging($date)
{
    $start_date = new \DateTime($date);
    $today = new \DateTime("today");
    if ($start_date > $today) { 
        return 0;
    }

    $date1=date_create($date);
    $date2=date_create();
    $diff=date_diff($date1,$date2);
    return $diff->format("%R%a days");
}

function sum_journal_cashflow_by_group($month,$year,$group)
{
    $sum = \App\Models\Journal::join('code_cashflows','code_cashflows.id','=','journals.code_cashflow_id')->where('group',$group)->whereYear('date_journal',$year)->whereMonth('date_journal',$month)->sum('saldo');
    return $sum?$sum:0;
}
function sum_journal_cashflow($year,$month,$cashflow)
{
    $sum = \App\Models\Journal::whereYear('date_journal',$year)->whereMonth('date_journal',$month)->where('code_cashflow_id',$cashflow)->sum('saldo');
    
    return ($sum ? $sum : 0);
}
function month()
{
    $month = [1=>"Januari",2=>"Februari",3=>"Maret",4=>"April",5=>"Mei",6=>"Juni",7=>"Juli",8=>"Agustus",9=>"September",10=>"Oktober",11=>"November",12=>"Desember"];

    return $month;
}
function replace_idr($nominal)
{
    if($nominal == "") return 0;

    $nominal = str_replace('Rp. ', '', $nominal);
    $nominal = str_replace(' ', '', $nominal);
    $nominal = str_replace('.', '', $nominal);
    $nominal = str_replace(',', '', $nominal);
    $nominal = str_replace('-', '', $nominal);
    $nominal = str_replace('(', '', $nominal);
    $nominal = str_replace(')', '', $nominal);

    return (int)$nominal;
}
function get_group_cashflow($key="")
{
    $data = [1=>'Operation Activities',2=>'Investment Activities',3=>'Financing Activities'];
    if($key!="") return @$data[$key];
    
    return $data;
}

function generate_no_voucher_konven_underwriting($coa_id)
{
    $coa = \App\Models\Coa::find($coa_id);
    $count = \App\Models\KonvenUnderwriting::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->count()+1;
    
    if($coa) return $coa->code_voucher.'-'.str_pad($count,3, '0', STR_PAD_LEFT).'/'.date('m').'/'.date('Y');

    return '';
}
function generate_no_voucher($coa_id="",$count="")
{
    $coa = \App\Models\Coa::find($coa_id);
    if(empty($count)) 
        $count = \App\Models\Journal::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->count()+1;
    if($coa) 
        return $coa->code_voucher.'-'.str_pad($count,3, '0', STR_PAD_LEFT).'/'.date('m').'/'.date('Y');

    return '';
}
function format_idr($number)
{
    if(empty($number)) return 0;
    $number = (int) $number;
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