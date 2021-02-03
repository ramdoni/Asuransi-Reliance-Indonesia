<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;

class Endorsement extends Component
{
    public $total_sync=0;
    public $perpage=100;
    protected $listeners = ['refresh-page'=>'$refresh'];
    public function render()
    {
        $data = \App\Models\SyariahEndorsement::orderBy('id','DESC');
        return view('livewire.syariah.endorsement')->with(['data'=>$data->paginate($this->perpage)]);
    }
    public function mount()
    {
        $this->total_sync = \App\Models\SyariahEndorsement::where('status',1)->count();
    }
}
