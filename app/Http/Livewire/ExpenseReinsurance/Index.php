<?php

namespace App\Http\Livewire\ExpenseReinsurance;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$status;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = \App\Models\Expenses::orderBy('id','desc')->where('reference_type','Reinsurance Premium');
        if($this->keyword) $data = $data->where('description','LIKE', "%{$this->keyword}%")
                                        ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ->orWhere('reference_no','LIKE',"%{$this->keyword}%");
        if($this->status) $data = $data->where('status',$this->status);

        return view('livewire.expense-reinsurance.index')->with(['data'=>$data->paginate(100)]);
    }
}