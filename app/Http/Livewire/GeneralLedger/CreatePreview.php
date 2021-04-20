<?php

namespace App\Http\Livewire\GeneralLedger;

use Livewire\Component;
use App\Models\Coa;
use App\Models\GeneralLedger;
use App\Models\Journal;

class CreatePreview extends Component
{
    public $submit_date,$coa,$month,$year,$message_error,$general_ledger_number;

    protected $listeners = ['preview-gl'=>'$refresh'];

    public function render()
    {
        return view('livewire.general-ledger.create-preview');
    }

    public function mount(Coa $coa)
    {
        $this->coa = $coa;
        $this->submit_date = date('Y-m-d');
    }

    public function delete(Journal $data)
    {
        $data->status_general_ledger=0;
        $data->save();
        $this->emit('added-journal', "Remove {$data->no_voucher}");
        $this->emit('preview-gl');
    }

    public function submit()
    {
        $this->validate([
            'year' => 'required',
            'month' => 'required'
        ]);

        $this->general_ledger_number = general_ledger_number();

        // check tahun apakah sudah di create dengan bulan dan tahun yang sama
        $check = GeneralLedger::where(['year'=>$this->year,'month'=>$this->month,'coa_id'=>$this->coa->id])->first();
        if($check){
            $this->message_error = "General Ledger sudah pernah dibuat.";
        }else{
            $data = new GeneralLedger();
            $data->general_ledger_number = $this->general_ledger_number;
            $data->submit_date = $this->submit_date;
            $data->user_id = \Auth::user()->id;
            $data->year = $this->year;
            $data->month = $this->month;
            $data->coa_id = $this->coa->id;
            $data->save();

            foreach(Journal::where('status_general_ledger',1)->get() as $journal){
                $journal->general_ledger_id = $data->id;
                $journal->status_general_ledger = 2;
                $journal->save();
            }

            session()->flash('message-success','General Ledger <a href="'.route('general-ledger.detail',$data->id).'">'.$this->general_ledger_number.'</a> Saved .');   
            
            return redirect()->route('general-ledger.create',$this->coa->id);
        }
    }
}