<?php

namespace App\Http\Livewire\BankBook;

use Livewire\Component;
use App\Models\BankAccount;

class Index extends Component
{
    public $set_active;
    public function render()
    {
        return view('livewire.bank-book.index');
    }

    public function set_active_($id)
    {
        $this->set_active = $id;
        $this->emit('set_active',$this->set_active);
    }

    public function mount()
    {
        $set_active = BankAccount::where('is_client',0)->where('status',1)->first();
        if($set_active) $this->set_active = $set_active->id;

        \LogActivity::add("Bank Book");
    }
}