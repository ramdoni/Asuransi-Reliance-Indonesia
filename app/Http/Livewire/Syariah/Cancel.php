<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;

class Cancel extends Component
{
    public $total_sync=0,$perpage=100;
    protected $listeners = ['refresh-page'=>'$refresh'];
    public function render()
    {
        $data = \App\Models\SyariahCancel::orderBy('id','DESC')->where('is_temp',0);
        
        return view('livewire.syariah.cancel')->with(['data'=>$data->paginate($this->perpage)]);
    }
    public function mount()
    {
        $this->total_sync = \App\Models\SyariahCancel::where('is_temp',0)->count();
    }
}
