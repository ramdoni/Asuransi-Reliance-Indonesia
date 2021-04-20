<?php

namespace App\Http\Livewire\GeneralLedger;

use Livewire\Component;
use App\Models\GeneralLedger;
use App\Models\Coa;
use App\Models\Journal;

class Revisi extends Component
{
    public $data,$coa,$journals;

    public function render()
    {
        return view('livewire.general-ledger.revisi');
    }

    public function mount(GeneralLedger $id)
    {
        $this->data = $id;
        $this->coa = $this->data->coa;
        $this->journals = Journal::where('general_ledger_id',$this->data->id)->get();
    }

    public function delete(Journal $journal)
    {
        dd($journal);

        $journal->general_ledger_id = NULL;
        $journal->status_general_ledger = NULL;
        $journal->save();
    }
}
