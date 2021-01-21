<?php

namespace App\Http\Livewire\IncomeReinsurance;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$coa_id,$status;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = \App\Models\Income::orderBy('id','desc')->where('reference_type','Reinsurance Commision');
        if($this->keyword) $data = $data->where('description','LIKE', "%{$this->keyword}%")
                                        ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ->orWhere('reference_no','LIKE',"%{$this->keyword}%");
        if($this->status) $data = $data->where('status',$this->status);

        return view('livewire.income-reinsurance.index')->with(['data'=>$data->paginate(100)]);
    }
}