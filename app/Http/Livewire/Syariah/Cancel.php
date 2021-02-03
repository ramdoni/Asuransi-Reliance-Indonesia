<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;

class Cancel extends Component
{
    public $total_sync=0;
    public function render()
    {
        return view('livewire.syariah.cancel');
    }
    public function mount()
    {
       // $this->total_sync = \App\Models\Syariah
    }
}
