<?php

namespace App\Http\Livewire\ExpenseClaim;

use Livewire\Component;

class Insert extends Component
{
    public $data,$no_voucher,$no_polis,$nilai_klaim,$premium_receivable,$is_submit=false;
    public $reference_no,$to_bank_account_id,$from_bank_account_id,$payment_date,$bank_charges,$description;
    public function render()
    {
        return view('livewire.expense-claim.insert');
    }
    public function mount()
    {
        $this->no_voucher = generate_no_voucher_expense();
    }
    public function updated($propertyName)
    {
        if($propertyName=='no_polis'){
            $this->data = \App\Models\Policy::find($this->no_polis);
            $premium = \App\Models\Income::select('income.*')->where(['income.reference_type'=>'Premium Receivable','income.transaction_table'=>'konven_underwriting'])
                                            ->join('konven_underwriting','konven_underwriting.id','=','income.transaction_id')
                                            ->where('konven_underwriting.no_polis',$this->data->no_polis);
            $total_premium_receive = clone $premium;
            if($total_premium_receive->where('income.status',2)->sum('income.payment_amount') > 0) $this->is_submit = true;
            else $this->is_submit = false;

            $this->premium_receivable = $premium->get();
        }
        $this->emit('init-form');
    }
    public function save()
    {
        $this->validate(
            [
                'no_polis' => 'required',
                'nilai_klaim' => 'required',
                'payment_date' => 'required',
                'from_bank_account_id' => 'required',
                'to_bank_account_id' => 'required'
            ]);
        $data = new \App\Models\Expenses();
        $data->policy_id = $this->data->id;
        $data->from_bank_account_id = $this->from_bank_account_id;
        $data->rekening_bank_id = $this->to_bank_account_id;
        $data->reference_type = 'Claim';
        $data->reference_no = $this->reference_no;
        $data->recipient = $this->data->no_polis.' - '. $this->data->pemegang_polis;
        $data->no_voucher = $this->no_voucher;
        $data->payment_amount = $this->nilai_klaim;
        $data->payment_date = $this->payment_date;
        $data->bank_charges = $this->bank_charges;
        $data->status = 2;
        $data->user_id = \Auth::user()->id;
        $data->description = $this->description;
        $data->save();

        session()->flash('message-success',__('Claim data has been successfully saved'));
        return redirect()->route('expense.claim');
    }
}
