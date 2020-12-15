<?php

namespace App\Http\Livewire\ExpenseClaim;

use Livewire\Component;

class Detail extends Component
{
    public $data,$outstanding_balance,$payment_amount,$payment_date,$total_amount,$bank_account_id;
    public function render()
    {
        return view('livewire.expense-claim.detail');
    }
    public function mount($id)
    {
        $this->data = \App\Models\Expenses::find($id);
        $this->payment_amount = $this->data->payment_amount;
        $this->total_amount = $this->data->nominal;
        $this->calculate();
    }
    public function calculate()
    {
        $this->outstanding_balance = format_idr(replace_idr($this->total_amount) - replace_idr($this->payment_amount));
    }
    public function save()
    {
        $this->payment_amount = replace_idr($this->payment_amount);
        $this->validate(
            [
                'bank_account_id'=>'required',
                'payment_amount' => 'required|numeric|max:'.replace_idr($this->total_amount),
            ],
            [
                'payment_amount.max' => 'The Payment Amount may not be greater than '. $this->total_amount
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
        return redirect()->route('expense.claim');
    }
}