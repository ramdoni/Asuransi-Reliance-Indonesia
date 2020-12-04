<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;

class UnderwritingDetail extends Component
{
    public $data,$coa_id,$debit,$kredit,$payment_date,$description;
    public $count_account=[],$total_debit=0,$total_kredit=0;
    public $no_voucher,$bank_account_id;
    public function render()
    {
        return view('livewire.konven.underwriting-detail');
    }

    public function mount($id)
    {
        $this->data = \App\Models\KonvenUnderwriting::find($id);
        $this->no_voucher = $this->data->no_voucher;
        foreach($this->data->coa as $k => $item){
            $this->coa_id[$k] = $item->coa_id;
            $this->description[$k] = $item->description;
            $this->payment_date[$k] = $item->payment_date;
            $this->debit[$k] = format_idr($item->debit);
            $this->kredit[$k] = format_idr($item->kredit);
            $this->total_debit += $item->debit;
            $this->total_kredit += $item->kredit;
        }
    }

    public function save()
    {
        $this->data->status=2;
        $this->data->save();

        foreach($this->data->coa as $k => $item){
            $item->coa_id = $this->coa_id[$k];
            $item->kredit = replace_idr($this->kredit[$k]);
            $item->debit = replace_idr($this->debit[$k]);
            $item->payment_date = date('Y-m-d',strtotime($this->payment_date[$k]));
            $item->description = $this->description[$k];
            $item->save();
        }

        session()->flash('message-success',__('Data saved successfully'));
        
        return redirect()->to('konven');
    }

    public function saveToJournal()
    {
        $this->validate([
            'bank_account_id'=>'required'
        ]);

        $this->data->status = 3;
        $this->data->save();

        foreach($this->data->coa as $k => $item){
            $item->coa_id = $this->coa_id[$k];
            $item->kredit = replace_idr($this->kredit[$k]);
            $item->debit = replace_idr($this->debit[$k]);
            $item->payment_date = date('Y-m-d',strtotime($this->payment_date[$k]));
            $item->description = $this->description[$k];
            $item->save();
        }
        
        foreach($this->data->coaDesc as $k => $item){
            $data  = new \App\Models\Journal();
            $data->transaction_id = $this->data->id;
            $data->transaction_table = 'konven_underwriting'; 
            $data->coa_id = $item->coa_id;
            $data->no_voucher = $this->no_voucher;
            $data->date_journal = date('Y-m-d',strtotime($this->payment_date[$k]));
            $data->debit = replace_idr(isset($this->debit[$k])?$this->debit[$k]:0);
            $data->kredit = replace_idr(isset($this->kredit[$k])?$this->kredit[$k]:0);
            $data->description = isset($this->description[$k])?$this->description[$k]:'';
            $data->bank_account_id = $this->bank_account_id;
            $data->saldo = replace_idr($this->debit[$k]!=0 ? $this->debit[$k] : ($this->kredit[$k]!=0?$this->kredit[$k] : 0));
            $data->save();
        }

        session()->flash('message-success','Submit to Journal success !');
            
        return redirect()->to('konven');
    }
}