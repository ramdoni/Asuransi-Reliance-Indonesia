<?php

namespace App\Http\Livewire\AccountReceivable;

use Livewire\Component;

class Edit extends Component
{
    public $data;
    public $account_id,$count_account,$rekening_bank_id,$amount;
    public function render()
    {
        return view('livewire.account-receivable.edit');
    }

    public function mount($id)
    {
        $this->count_account[] = 1;
        $this->data = \App\Models\Income::find($id);
    }

    public function addAccountForm()
    {
        $this->count_account[] = count($this->count_account);
    }

    public function deleteAccountForm($key)
    {
        unset($this->count_account[$key]);
    }
}
