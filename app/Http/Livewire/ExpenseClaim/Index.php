<?php

namespace App\Http\Livewire\ExpenseClaim;

use Livewire\Component;

class Index extends Component
{
    public $keyword,$status;
    public function render()
    {
        $data = \App\Models\Expenses::orderBy('id','desc')->where('reference_type','Claim');
        if($this->keyword) $data = $data->where('description','LIKE', "%{$this->keyword}%")
                                        ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ->orWhere('reference_no','LIKE',"%{$this->keyword}%");
        if($this->status) $data = $data->where('status',$this->status);

        return view('livewire.expense-claim.index')->with(['data'=>$data->paginate(100)]);
    }
    public function mount()
    {
        \LogActivity::add("Expense Claim");
    }
}
