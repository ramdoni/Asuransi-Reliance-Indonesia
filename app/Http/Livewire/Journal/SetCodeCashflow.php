<?php

namespace App\Http\Livewire\Journal;

use Livewire\Component;

class SetCodeCashflow extends Component
{
    public $code_cashflow_id,$active_id;
    protected $listeners = ['modalEdit'];
    public function render()
    {
        return view('livewire.journal.set-code-cashflow');
    }

    public function mount()
    {
    }
    public function modalEdit($id)
    {
        $this->active_id = $id;
    }
    public function save()
    {
        $this->validate([
            'code_cashflow_id'=>'required'
        ]);
    }
}
