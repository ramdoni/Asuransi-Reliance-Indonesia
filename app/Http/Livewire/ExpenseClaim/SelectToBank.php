<?php

namespace App\Http\Livewire\ExpenseClaim;

use Livewire\Component;

class SelectToBank extends Component
{
    public $to_bank_account_id;
    protected $listeners = ['emit-add-bank'=>'emitAddBank'];

    public function render()
    {
        return view('livewire.expense-claim.select-to-bank');
    }
    
    public function emitAddBank($id)
    {
        $this->to_bank_account_id = $id;
    }
}
