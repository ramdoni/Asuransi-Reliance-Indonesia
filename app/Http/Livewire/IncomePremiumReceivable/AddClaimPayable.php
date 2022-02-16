<?php

namespace App\Http\Livewire\IncomePremiumReceivable;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Expenses;

class AddClaimPayable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $data,$keyword,$status,$type;
    public function render()
    {
        $data = Expenses::select('expenses.*')
        ->with(['pesertas'])
        ->orderBy('expenses.id','desc')->where('expenses.reference_type','Claim')->groupBy('expenses.id')
        ->leftJoin('expense_pesertas','expense_pesertas.expense_id','=','expenses.id')
        ->where('status',4); // hanya statusnya draft saja

        if($this->keyword) $data = $data->where(function($table){
                $table->where('expenses.description','LIKE', "%{$this->keyword}%")
                    ->orWhere('expenses.no_voucher','LIKE',"%{$this->keyword}%")
                    ->orWhere('expenses.reference_no','LIKE',"%{$this->keyword}%")
                    ->orWhere('expense_pesertas.no_peserta','LIKE',"%{$this->keyword}%")
                    ->orWhere('expense_pesertas.nama_peserta','LIKE',"%{$this->keyword}%");
                });
        if($this->status) $data = $data->where('expenses.status',$this->status);
        if($this->type) $data = $data->where('expenses.type',$this->type);

        return view('livewire.income-premium-receivable.add-claim-payable')->with(['claim'=>$data->paginate(20)]);
    }

    public function mount($data)
    {
        $this->data = $data;
    }
}
