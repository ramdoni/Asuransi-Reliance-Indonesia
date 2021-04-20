<?php

namespace App\Http\Livewire\GeneralLedger;

use Livewire\Component;
use App\Models\GeneralLedger;
use App\Models\Journal;

class Detail extends Component
{
    public $data,$coa,$journals;

    public function render()
    {
        return view('livewire.general-ledger.detail');
    }

    public function mount(GeneralLedger $id)
    {
        $this->data = $id;
        $this->coa = $this->data->coa;
        $this->journals = Journal::where('general_ledger_id',$this->data->id)->get();
    }
}
