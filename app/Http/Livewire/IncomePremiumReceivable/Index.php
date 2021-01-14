<?php

namespace App\Http\Livewire\IncomePremiumReceivable;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$coa_id,$status;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = \App\Models\Income::orderBy('id','desc')->where('reference_type','Premium Receivable');
        if($this->keyword) $data = $data->where('description','LIKE', "%{$this->keyword}%")
                                        ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ->orWhere('reference_no','LIKE',"%{$this->keyword}%")
                                        ->orWhere('client','LIKE',"%{$this->keyword}%")
                                        ;

        if($this->coa_id) $data = $data->where('coa_id',$this->coa_id);
        if($this->status) $data = $data->where('status',$this->status);

        return view('livewire.income-premium-receivable.index')->with(['data'=>$data->paginate(100)]);
    }
}
