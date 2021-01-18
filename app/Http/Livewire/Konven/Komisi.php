<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;

class Komisi extends Component
{
    public $total_sync=0;
    public function render()
    {
        $data = \App\Models\KonvenKomisi::orderBy('id','DESC');

        return view('livewire.konven.komisi')->with(['data'=>$data->paginate(100)]);
    }
}
