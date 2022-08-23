<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BankAccount;

class BankBooksSummary extends Model
{
    use HasFactory;

    protected $table = 'bank_books_summary';

    public function bank()
    {
        return $this->hasOne(BankAccount::class,'id','bank_account_id');
    }
}
