<?php

function status_expense($status) {
    switch($status){
        case 1:
            return "<label class=\"badge text-warning\">Waiting</label>";
        break;
        case 2:
            return "<label class=\"badge text-success\">Completed</label>";
        break;
    }
}

function generate_no_voucher_expense()
{
    $count = \App\Models\Expenses::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->count()+1;
    
    return date('y').date('m').str_pad($count,5, '0', STR_PAD_LEFT);
}