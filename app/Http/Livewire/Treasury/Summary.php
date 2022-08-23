<?php

namespace App\Http\Livewire\Treasury;

use App\Models\BankAccount;
use App\Models\BankBook;
use App\Models\BankBooksSummary;
use Livewire\Component;

class Summary extends Component
{
    public function render()
    {
        $bank_book = BankBooksSummary::get();
        
        return view('livewire.treasury.summary')->with(['summary'=>$bank_book]);
    }
}
