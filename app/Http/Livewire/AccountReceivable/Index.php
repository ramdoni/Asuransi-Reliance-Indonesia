<?php

namespace App\Http\Livewire\AccountReceivable;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$coa_id;
    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        $data = \App\Models\Income::orderBy('id','desc');

        if($this->keyword) $data = $data->where('description','LIKE', "%{$this->keyword}%")
                                        ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ;

        if($this->coa_id) $data = $data->where('coa_id',$this->coa_id);

        return view('livewire.account-receivable.index')->with(['data'=>$data->paginate(50)]);
    }
}
