<?php

namespace App\Http\Livewire\IncomeTitipanPremi;

use Livewire\Component;

class Insert extends Component
{
    public $no_voucher,$reference_no,$type,$payment_amount,$payment_date,$reference_type,$description,$data,$nominal,$from_bank_account_id,$to_bank_account_id,$is_readonly=false;
    public function render()
    {
        return view('livewire.income-titipan-premi.insert');
    }
    public function mount()
    { 
        $this->no_voucher = generate_no_voucher_income();
    }
    public function updated()
    {
        $this->emit('init-form');
    }
    public function save()
    {
        $this->validate(
            [   
                'nominal' => 'required',
                'from_bank_account_id' => 'required',
                'to_bank_account_id' => 'required',
            ]);
        $data = new \App\Models\Income();
        $data->no_voucher = $this->no_voucher;
        $data->payment_date = $this->payment_date;
        $data->reference_no = $this->reference_no;
        $data->reference_type = 'Titipan Premi';
        $data->nominal = replace_idr($this->nominal);
        $data->description = $this->description;
        $data->rekening_bank_id = $this->to_bank_account_id;
        $data->from_bank_account_id = $this->from_bank_account_id;
        $data->payment_amount = replace_idr($this->payment_amount);
        $data->user_id = \Auth::user()->id;
        $data->type = $this->type;
        $data->save();
        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('income.titipan-premi');
    }
}
