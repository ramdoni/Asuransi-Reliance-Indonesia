<?php

namespace App\Http\Livewire\IncomePremiumReceivable;

use Livewire\Component;

class Detail extends Component
{
    public $data,$no_voucher,$client,$recipient,$reference_type,$reference_no,$reference_date,$description,$nominal,$outstanding_balance,$tax_id,$payment_amount=0,$bank_account_id;
    public $payment_date,$tax_amount,$total_amount,$is_readonly=false;
    public function render()
    {
        return view('livewire.income-premium-receivable.detail');
    }
    public function mount($id)
    {
        $this->data = \App\Models\Income::find($id);
        $this->no_voucher = $this->data->no_voucher;
        $this->total_amount = format_idr($this->data->nominal);
        $this->payment_date = $this->data->payment_date?$this->data->payment_date : date('Y-m-d');
        $this->bank_account_id = $this->data->rekening_bank_id;
        $this->payment_amount = $this->data->payment_amount;
        if($this->data->status==2) $this->is_readonly = true;
        $this->calculate();
    }
    public function calculate()
    {
        $this->outstanding_balance = format_idr(replace_idr($this->total_amount) - replace_idr($this->payment_amount));
    }
    public function save()
    {
        if($this->is_readonly) return false;
        $this->payment_amount = replace_idr($this->payment_amount);
        $this->validate(
            [
                'bank_account_id'=>'required',
                'payment_amount'=>'required|numeric|max:'.replace_idr($this->total_amount),
            ],
            [
                'payment_amount.max'=>'The Payment Amount may not be greater than '. $this->total_amount
            ]
        );
        if($this->payment_amount == replace_idr($this->total_amount))
            $this->data->status = 2; //outstanding
        if($this->outstanding_balance !=0)
            $this->data->status = 3;

        $this->data->outstanding_balance = replace_idr($this->outstanding_balance);
        $this->data->payment_amount = $this->payment_amount;
        $this->data->rekening_bank_id = $this->bank_account_id;
        $this->data->payment_date = $this->payment_date;
        $this->data->save();
        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('income.premium-receivable');
    }
}
