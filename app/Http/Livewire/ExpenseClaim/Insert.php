<?php

namespace App\Http\Livewire\ExpenseClaim;

use Livewire\Component;

class Insert extends Component
{
    public $data,$no_voucher,$no_polis,$nilai_klaim,$premium_receivable;
    public function render()
    {
        return view('livewire.expense-claim.insert');
    }
    public function mount()
    {
        $this->no_voucher = generate_no_voucher_expense();
    }
    public function updated($propertyName)
    {
        if($propertyName=='no_polis'){
            $this->data = \App\Models\Policy::find($this->no_polis);
            $this->premium_receivable = \App\Models\Income::select('income.*')->where(['income.reference_type'=>'Premium Receivable','income.transaction_table'=>'konven_underwriting'])
                                            ->join('konven_underwriting','konven_underwriting.id','=','income.transaction_id')
                                            ->where('konven_underwriting.no_polis',$this->data->no_polis)
                                            ->get();
        }
        $this->emit('init-form');
    }
}
