<?php

namespace App\Http\Livewire\ExpenseCommisionPayable;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$unit,$status;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = \App\Models\Expenses::orderBy('id','desc')->where('reference_type','Komisi');
        if($this->keyword) $data = $data->where(function($table){
                                            $table->where('description','LIKE', "%{$this->keyword}%")
                                            ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                            ->orWhere('reference_no','LIKE',"%{$this->keyword}%")
                                            ->orWhere('recipient','LIKE',"%{$this->keyword}%");
                                        });
        if($this->status) $data = $data->where('status',$this->status);
        if($this->unit) $data = $data->where('type',$this->unit);
        return view('livewire.expense-commision-payable.index')->with(['data'=>$data->paginate(100)]);
    }
    public function delete($id)
    {
        \App\Models\Expenses::find($id)->delete();
        \App\Models\ExpensePayment::where('expense_id',$id)->delete();
        \LogActivity::add("Expense - Commision Payable Delete {$id}");
    }
    public function mount()
    {
        \LogActivity::add('Expense - Commision Payable');
    }
}