<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BankAccount;

class BankBook extends Model
{
    use HasFactory;

    public function from_bank()
    {
        return $this->belongsTo(BankAccount::class,'from_bank_id');
    }

    public function to_bank()
    {
        return $this->belongsTo(BankAccount::class,'to_bank_id');
    }
}
