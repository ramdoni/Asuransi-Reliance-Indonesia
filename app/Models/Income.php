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
        return $this->hasMany('\App\Models\journal','transaction_id','id')->where('transaction_table','income');
    }
}