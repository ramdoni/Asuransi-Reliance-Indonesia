<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table="income";

    public function policys()
    {
        return $this->hasOne('\App\Models\Policy','id','policy_id');
    }

    public function bank_account()
    {
        return $this->hasOne('\App\Models\BankAccount','id','rekening_bank_id');
    }

    public function coa()
    {
        return $this->hasMany('\App\Models\IncomeCoa','income_id','id');
    }

    public function journals()
    {
        return $this->hasMany('\App\Models\Journal','transaction_id','id')->where('transaction_table','income');
    }
    public function uw()
    {
        return $this->hasOne('\App\Models\KonvenUnderwriting','id','transaction_id');
    }
    public function cancelation()
    {
        return $this->hasMany('\App\Models\KonvenUnderwritingCancelation','income_id','id');
    }
    public function total_cancelation()
    {
        return $this->hasMany('\App\Models\KonvenUnderwritingCancelation','income_id','id');
    }
    public function from_bank_account()
    {
        return $this->belongsTo(\App\Models\BankAccount::class,'from_bank_account_id');
    }
}