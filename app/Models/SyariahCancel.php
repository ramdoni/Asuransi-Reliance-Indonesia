<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyariahCancel extends Model
{
    use HasFactory;
    protected $table = 'syariah_cancel';
    public function parent()
    {
        return $this->hasOne(\App\Models\SyariahEndorsement::class,'id','parent_id');
    }
}
