<?php

namespace App\Http\Livewire\IncomeRecoveryRefund;

use Livewire\Component;

class Detail extends Component
{
    public $data,$income,$add_pesertas;
    public function render()
    {
        return view('livewire.income-recovery-refund.detail');
    }
    public function mount($id)
    {
        $this->income = \App\Models\Income::find($id);
        $this->data = \App\Models\Policy::find($this->income->policy_id);
        $this->add_pesertas = \App\Models\IncomePeserta::where('income_id',$this->income->id)->get(); 
    }
}