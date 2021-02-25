<?php

namespace App\Http\Livewire\IncomeRecoveryClaim;

use Livewire\Component;

class Insert extends Component
{
    public $type=1,$no_voucher,$is_submit=true,$data,$premium_receivable,$expense_id,$outstanding_balance,$reference_no,$payment_amount,$from_bank_account_id,$to_bank_account_id;
    public $is_readonly=false,$payment_date,$bank_charges,$description,$reference_date;
    protected $listeners = ['emit-add-bank'=>'emitAddBank'];
    public function render()
    {
        return view('livewire.income-recovery-claim.insert');
    }
    public function mount()
    {
        $this->no_voucher = generate_no_voucher_income();
        $this->payment_date = date('Y-m-d');
        $this->reference_date = date('Y-m-d');
    }
    public function emitAddBank($id)
    {
        $this->from_bank_account_id = $id;
        $this->emit('init-form');
    }
    public function updated($propertyName)
    {
        if($propertyName=='expense_id'){
            $this->data = \App\Models\Expenses::find($this->expense_id);
        }
        $this->emit('init-form');
    }
    public function save()
    {
        $this->validate([
            'type' => 'required',
            'expense_id' => 'required',
            'payment_amount' => 'required'
        ]);
        $this->payment_amount = replace_idr($this->payment_amount);
        $this->bank_charges = replace_idr($this->bank_charges);
        $data = new \App\Models\Income();
        $data->no_voucher = $this->no_voucher;
        $data->reference_type = 'Recovery Claim';
        $data->description = $this->description;
        $data->outstanding_balance = $this->outstanding_balance;
        $data->reference_no = $this->reference_no;
        $data->client = isset($this->data->policy->no_polis) ? $this->data->policy->no_polis .' / '. $this->data->policy->pemegang_polis : '';
        $data->rekening_bank_id = $this->to_bank_account_id;
        $data->from_bank_account_id = $this->from_bank_account_id;
        $data->reference_date = $this->reference_date;
        $data->status = 2;
        $data->user_id = \Auth::user()->id;
        $data->payment_amount = $this->payment_amount;
        $data->bank_charges = $this->bank_charges;
        $data->payment_date = $this->payment_date;
        $data->type = $this->type;
        $data->transaction_id = $this->expense_id;
        $data->transaction_table = 'expenses';
        $data->save();

        \LogActivity::add("Income - Recovery Claim Submit {$this->data->id}");

        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('income.recovery-claim');
    }
}
