<?php

namespace App\Http\Livewire\CashFlow;

use Livewire\Component;

class OjkReport extends Component
{
    public $year,$month;
    public function render()
    {
        return view('livewire.cash-flow.ojk-report');
    }

    public function mount()
    {
        $this->year = date('Y');
    }
}