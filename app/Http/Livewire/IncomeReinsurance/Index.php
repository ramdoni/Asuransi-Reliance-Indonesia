<?php

namespace App\Http\Livewire\IncomeReinsurance;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$type,$status;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = \App\Models\Income::orderBy('id','desc')->where('reference_type','Reinsurance Commision');
        if($this->keyword) $data = $data->where(function($table){
                                            $table->where('description','LIKE', "%{$this->keyword}%")
                                                   ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                                   ->orWhere('reference_no','LIKE',"%{$this->keyword}%");
                                        });
        if($this->status) $data = $data->where('status',$this->status);
        if($this->type) $data = $data->where('type',$this->type);
        return view('livewire.income-reinsurance.index')->with(['data'=>$data->paginate(100)]);
    }
    public function mount()
    {
        \LogActivity::add('Income - Reinsurance Commision');
    }
}