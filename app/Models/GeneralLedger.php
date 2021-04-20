<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Coa;

class GeneralLedger extends Model
{
    use HasFactory;

    protected $table = 'general_ledger';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function coa()
    {
        return $this->belongsTo(Coa::class,'coa_id');
    }
}
