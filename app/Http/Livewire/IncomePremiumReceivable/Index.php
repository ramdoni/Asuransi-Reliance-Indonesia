<?php

namespace App\Http\Livewire\IncomePremiumReceivable;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$unit,$status,$payment_date,$voucher_date;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = \App\Models\Income::orderBy('id','desc')->where('reference_type','Premium Receivable');
        $received = clone $data;
        $outstanding = clone $data;
        
        if($this->keyword) $data = $data->where('description','LIKE', "%{$this->keyword}%")
                                        ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ->orWhere('reference_no','LIKE',"%{$this->keyword}%")
                                        ->orWhere('client','LIKE',"%{$this->keyword}%");

        if($this->unit) $data = $data->where('type',$this->unit);
        if($this->status) $data = $data->where('status',$this->status);
        if($this->payment_date) $data = $data->where('payment_date',$this->payment_date);
        if($this->voucher_date) $data = $data->whereDate('created_at',$this->voucher_date);

        return view('livewire.income-premium-receivable.index')->with(['data'=>$data->paginate(100),'received'=>$received->where('status',2)->sum('payment_amount'),'outstanding'=>$outstanding->where('status',3)->sum('outstanding_balance'),]);
    }
    public function mount()
    {
        \LogActivity::add('Income - Premium Receivable');
    }
}