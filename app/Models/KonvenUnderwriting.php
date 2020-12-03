<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonvenUnderwriting extends Model
{
    use HasFactory;

    protected $table = 'konven_underwriting';

    public function coa()
    {
        return $this->hasMany('\App\Models\KonvenUnderwritingCoa','konven_underwriting_id','id');
    }

    public function coaDesc()
    {
        return $this->hasMany('\App\Models\KonvenUnderwritingCoa','konven_underwriting_id','id')->orderBy('id','DESC');  
    }
}
