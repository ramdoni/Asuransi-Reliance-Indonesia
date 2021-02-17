<?php

namespace App\Http\Livewire\ExpenseReinsurance;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$status,$unit,$received,$outstanding;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = \App\Models\Expenses::orderBy('id','desc')->where('reference_type','Reinsurance Premium');
        if($this->keyword) $data = $data->where(function($table){
                                        $table->where('description','LIKE', "%{$this->keyword}%")
                                        ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ->orWhere('reference_no','LIKE',"%{$this->keyword}%")
                                        ->orWhere('recipient','LIKE',"%{$this->keyword}%")
                                        ;
                                    });
        if($this->status) $data = $data->where('status',$this->status);
        if($this->unit) $data = $data->where('type',$this->unit);
        $this->received = clone $data;$this->received = $this->received->where('status',2)->sum('payment_amount');
        $this->outstanding = clone $data;$this->outstanding = $this->outstanding->sum('outstanding_balance');
        return view('livewire.expense-reinsurance.index')->with(['data'=>$data->paginate(100)]);
    }
    public function mount()
    {
        \LogActivity::add('Expense - Reinsurance Premium');
    }
}