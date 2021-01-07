<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    public function bank_account()
    {
        return $this->hasOne('\App\Models\BankAccount','id','rekening_bank_id');
    }
    public function uw()
    {
        return $this->hasOne('\App\Models\KonvenUnderwriting','id','transaction_id');
    }
    public function coa()
    {
        return $this->hasMany('\App\Models\ExpenseCoa','expense_id','id');
    }
    public function tax()
    {
        return $this->hasOne('\App\Models\SalesTax','id','tax_id');
    }
    public function claim()
    {
        return $this->hasOne('\App\Models\KonvenClaim','id','transaction_id');
    }
    public function memo()
    {
        return $this->hasOne('\App\Models\KonvenMemo','id','transaction_id');
    }
}