<?php

namespace App\Http\Livewire\Accounting\Others;

use Livewire\Component;
use App\Models\Expenses;
use Livewire\WithPagination;

class Payable extends Component
{
    public $keyword,$type,$status;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = Expenses::with('others_payment')->orderBy('id','DESC')->where('is_others',1);
        if($this->keyword) $data = $data->where(function($table){
            $table->where('description','LIKE', "%{$this->keyword}%")
            ->orWhere('no_voucher','LIKE',"%{$this->keyword}%")
            ->orWhere('reference_no','LIKE',"%{$this->keyword}%")
            ->orWhere('recipient','LIKE',"%{$this->keyword}%");
        });
        if($this->type) $data = $data->where('type',$this->type);
        if($this->status) $data = $data->where('status',$this->status);

        return view('livewire.accounting.others.payable')->with(['data'=>$data->paginate(100)]);
    }
}
