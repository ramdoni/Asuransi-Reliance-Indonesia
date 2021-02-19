<?php

namespace App\Http\Livewire\ExpenseClaim;

use Livewire\Component;

class Index extends Component
{
    public $keyword,$status,$type;
    public function render()
    {
        $data = \App\Models\Expenses::orderBy('id','desc')->where('reference_type','Claim');
        if($this->keyword) $data = $data->where(function($data){
                                    $data->where('description','LIKE', "%{$this->keyword}%")
                                    ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                    ->orWhere('reference_no','LIKE',"%{$this->keyword}%");
                                        });
        if($this->status) $data = $data->where('status',$this->status);
        if($this->type) $data = $data->where('type',$this->type);
        return view('livewire.expense-claim.index')->with(['data'=>$data->paginate(100)]);
    }
    public function mount()
    {
        \LogActivity::add("Expense Claim");
    }
    public function delete($id)
    {
        \LogActivity::add("Expense Claim Delete {$id}");
        \App\Models\Expenses::find($id)->delete();
    }
}
