<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;
use Livewire\WithPagination;

class Underwriting extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $total_sync=0;
    public function render()
    {
        $data = \App\Models\SyariahUnderwriting::orderBy('id','DESC');
        
        return view('livewire.syariah.underwriting')->with(['data'=>$data->paginate(100)]);
    }
    public function mount()
    {
        $this->total_sync = \App\Models\SyariahUnderwriting::where('status',1)->count();
    }
}
