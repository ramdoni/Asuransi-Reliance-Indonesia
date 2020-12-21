<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;

class MemoPos extends Component
{
    public $total_sync=0;
    public function render()
    {
        $data = \App\Models\KonvenMemo::orderBy('id','DESC');
        
        return view('livewire.konven.memo-pos')->with(['data'=>$data->paginate(100)]);
    }
}
