<?php

namespace App\Http\Livewire\ExpenseRefund;

use Livewire\Component;

class Detail extends Component
{
    public $data,$no_voucher,$client,$recipient,$reference_type,$reference_no,$reference_date,$description,$outstanding_balance,$tax_id,$payment_amount=0,$bank_account_id,$from_bank_account_id;
    public $payment_date,$tax_amount,$total_payment_amount,$is_readonly=false,$is_finish=false,$paid_premi=1,$paid_premi_id;
    public $bank_charges;
    public function render()
    {
        return view('livewire.expense-refund.detail');
    }
    public function mount($id)
    {
        $this->data = \App\Models\Expenses::find($id);
        $this->no_voucher = $this->data->no_voucher;
        $this->payment_date = $this->data->payment_date?$this->data->payment_date : date('Y-m-d');
        $this->bank_account_id = $this->data->rekening_bank_id;
        $this->payment_amount = format_idr($this->data->payment_amount);
        $this->total_payment_amount = $this->data->total_payment_amount;
        $premi = \App\Models\Income::where('transaction_id',$this->data->uw->id)->where('transaction_table','konven_underwriting')->first();
        if($premi){
            $this->paid_premi = $premi->status;
            $this->paid_premi_id =$premi->id;
            if($premi->status!=2) $this->is_readonly = true;
        }
        if($this->payment_amount =="") $this->payment_amount=$this->data->nominal;
        if($this->data->status==2) $this->is_finish = true;
    }
    public function save()
    {
        // if($this->is_finish) return false;
        $this->validate(
            [
                'bank_account_id'=>'required',
                'payment_amount'=>'required',
            ]
        );
        $this->payment_amount = replace_idr($this->payment_amount);
        if($this->payment_amount==$this->data->nominal) $this->data->status=2;//paid
        if($this->payment_amount!=$this->data->nominal) $this->data->status=3;//outstanding
        $this->data->outstanding_balance = replace_idr($this->outstanding_balance);
        $this->data->payment_amount = $this->payment_amount;
        $this->data->rekening_bank_id = $this->bank_account_id;
        $this->data->payment_date = $this->payment_date;
        $this->data->save();    
        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('expense-refund');
    }
}