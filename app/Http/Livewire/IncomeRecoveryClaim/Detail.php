<?php

namespace App\Http\Livewire\IncomeRecoveryClaim;

use Livewire\Component;

class Detail extends Component
{
    public $expense,$type=1,$no_voucher,$is_submit=true,$data,$premium_receivable,$expense_id,$outstanding_balance,$reference_no,$payment_amount,$from_bank_account_id,$to_bank_account_id;
    public $is_readonly=false,$payment_date,$bank_charges,$description,$reference_date;
    public function render()
    {
        return view('livewire.income-recovery-claim.detail');
    }
    public function mount($id)
    {
        $this->data = \App\Models\Income::find($id);
        $this->expense = \App\Models\Expenses::find($this->data->transaction_id);
        $this->no_voucher = generate_no_voucher_income();
        $this->payment_date = date('Y-m-d');
        $this->reference_date = date('Y-m-d');
    }
}
