<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;

class Underwriting extends Component
{
    public function render()
    {
        $data = \App\Models\SyariahUnderwriting::orderBy('id','DESC');
        
        return view('livewire.syariah.underwriting')->with(['data'=>$data->paginate(100)]);
    }
}
