<?php

namespace App\Http\Livewire\CashFlow;

use Livewire\Component;

class InternalReport extends Component
{
    public $year,$month;
    public function render()
    {
        return view('livewire.cash-flow.internal-report');
    }

    public function mount()
    {
        $this->year = date('Y');
    }
}
