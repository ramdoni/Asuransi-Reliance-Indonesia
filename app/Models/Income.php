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
}