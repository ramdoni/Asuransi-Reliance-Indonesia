<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $table = 'policys';
    public function reas()
    {
        return $this->belongsTo(\App\Models\KonvenReinsurance::class,'no_polis','no_polis');
    }
}
