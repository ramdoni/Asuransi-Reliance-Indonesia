<?php

namespace App\Http\Livewire\AccountPayable;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$coa_id;
    protected $paginationTheme = 'bootstrap';
    
    public function render()
    {
        $data = \App\Models\Journal::orderBy('id','desc')->where('type',1);

        if($this->keyword) $data = $data->where('description','LIKE', "%{$this->keyword}%")
                                        ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ->orWhere('debit','LIKE',"{$this->keyword}");

        if($this->coa_id) $data = $data->where('coa_id',$this->coa_id);

        return view('livewire.account-payable.index')->with(['data'=>$data->paginate(50)]);
    }
}
