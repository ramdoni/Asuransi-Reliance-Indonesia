<?php

namespace App\Http\Livewire\Accounting\Others;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Income;

class Receivable extends Component
{
    public $keyword;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = Income::with('others_payment')->orderBy('id','desc')->where('is_others',1)
                            ->whereHas('others_payment',function($query){
                                if($this->keyword) $query->where('income_payments.description','LIKE',"%{$this->keyword}%");
                            });
        
        if($this->keyword) $data->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
                                        ->orWhere('reference_no','LIKE',"%{$this->keyword}%")
                                        ->orWhere('client','LIKE',"%{$this->keyword}%");
                                        
        return view('livewire.accounting.others.receivable')->with(['data'=>$data->paginate(100)]);
    }
}
