<?php

namespace App\Http\Livewire\AccountingJournal;

use Livewire\Component;

class Detail extends Component
{
    public $data,$total_amount,$payment_amount,$count_account=[],$is_readonly=false,$total_debit,$total_kredit;
    public $is_submit_journal,$coas,$is_reclass=false;
    public $uw;
    public function render()
    {
        return view('livewire.accounting-journal.detail');
    }
    public function mount($id)
    {
        $this->data = \App\Models\Journal::find($id);
        $this->coas = \App\Models\Journal::where('no_voucher', $this->data->no_voucher)->get();
        if($this->data->transaction_table=='konven_underwriting'){
            $this->uw = \App\Models\KonvenUnderwriting::find($this->data->transaction_id);
        }

        \LogActivity::add("Accounting - Journal Detail {$id}");
    }
    public function cancel_reclass()
    {
        $this->is_reclass=false;
        $this->emit('changeForm');
        $this->reset(['count_account']);
    }
    public function reclass()
    {
        $this->is_reclass=true;
        $this->emit('changeForm');
        $this->count_account[] = [];
    }
}