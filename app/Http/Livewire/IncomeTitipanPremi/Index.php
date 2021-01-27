<?php

namespace App\Http\Livewire\IncomeTitipanPremi;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$unit,$status,$payment_date,$voucher_date;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = \App\Models\Income::orderBy('id','desc')->where('reference_type','Titipan Premi');
        if($this->keyword) $data = $data->where('description','LIKE', "%{$this->keyword}%")
                                        ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ->orWhere('reference_no','LIKE',"%{$this->keyword}%")
                                        ->orWhere('client','LIKE',"%{$this->keyword}%");

        if($this->unit) $data = $data->where('type',$this->unit);
        if($this->status) $data = $data->where('status',$this->status);
        if($this->payment_date) $data = $data->where('payment_date',$this->payment_date);
        if($this->voucher_date) $data = $data->whereDate('created_at',$this->voucher_date);

        return view('livewire.income-titipan-premi.index')->with(['data'=>$data->paginate(100)]);
    }
}
