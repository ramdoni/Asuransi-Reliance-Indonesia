<?php

namespace App\Http\Livewire\IncomePremiumReceivable;

use Livewire\Component;

class DetailOld extends Component
{
    public $data,$no_voucher,$client,$recipient,$reference_type,$reference_no,$reference_date,$description,$nominal,$outstanding_balance,$tax_id,$payment_amount=0,$bank_account_id;
    public $payment_date,$tax_amount,$total_payment_amount,$is_readonly=false,$is_finish=false;
    public $add_payment=[],$add_payment_id=[],$add_payment_amount,$add_payment_date,$add_payment_bank_account_id;
    public function render()
    {
        return view('livewire.income-premium-receivable.detail');
    }
    public function mount($id)
    {
        $this->data = \App\Models\Income::find($id);
        $this->no_voucher = $this->data->no_voucher;
        $this->nominal = format_idr($this->data->nominal);
        $this->payment_date = $this->data->payment_date?$this->data->payment_date : date('Y-m-d');
        $this->bank_account_id = $this->data->rekening_bank_id;
        $this->payment_amount = $this->data->payment_amount;
        $this->total_payment_amount = $this->data->total_payment_amount;
        if($this->data->status!=1) $this->is_readonly = true;
        if($this->data->status==2) $this->is_finish = true;
        foreach(\App\Models\IncomePayment::where('income_id',$this->data->id)->get() as $k=>$item){
            $this->add_payment[$k] = '';
            $this->add_payment_id[$k]=$item->id;
            $this->add_payment_amount[$k]=$item->payment_amount;
            $this->add_payment_date[$k]=$item->payment_date;
            $this->add_payment_bank_account_id[$k]=$item->bank_account_id;
        }
        $this->calculate();
    }
    public function calculate()
    {
        $this->total_payment_amount = replace_idr($this->payment_amount);
        foreach($this->add_payment as $k => $i){
            $this->total_payment_amount += replace_idr($this->add_payment_amount[$k]);
        }
        $this->outstanding_balance = format_idr(abs($this->total_payment_amount - $this->data->nominal));
    }
    public function save()
    {
        if($this->is_finish) return false;
        $this->payment_amount = replace_idr($this->payment_amount);
        $validate = [
            'bank_account_id'=>'required',
            'payment_amount'=>'required',
            //'payment_amount'=>'required|numeric|max:'.replace_idr($this->total_payment_amount),
        ];
        foreach($this->add_payment as $k => $i){
            $validate['add_payment_amount.'.$k] = 'required';
            $validate['add_payment_date.'.$k] = 'required';
            $validate['add_payment_bank_account_id.'.$k] = 'required';
        }
        $this->validate($validate);
        if($this->data->nominal == replace_idr($this->total_payment_amount))
            $this->data->status = 2; //paid
        if($this->outstanding_balance !=0)
            $this->data->status = 3; //outstanding

        $this->data->outstanding_balance = replace_idr($this->outstanding_balance);
        $this->data->payment_amount = $this->payment_amount;
        $this->data->rekening_bank_id = $this->bank_account_id;
        $this->data->payment_date = $this->payment_date;
        $this->data->save();

        foreach($this->add_payment as $k => $i){
            if(empty($this->add_payment_amount[$k])) continue; // skip
            if($this->add_payment_id[$k]!="") continue; //skip
            $insert = new \App\Models\IncomePayment();
            $insert->income_id = $this->data->id;
            $insert->payment_amount = replace_idr($this->add_payment_amount[$k]);
            $insert->payment_date = date('Y-m-d',strtotime($this->add_payment_date[$k]));
            $insert->bank_account_id = $this->add_payment_bank_account_id[$k];
            $insert->save();
        }
        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('income.premium-receivable');
    }
    public function addPayment() 
    {
        $this->add_payment[] = '';
        $this->add_payment_amount[] = 0;
        $this->add_payment_date[] = date('Y-m-d');
        $this->add_payment_bank_account_id[] = '';
        $this->emit('changeForm');
    }
    public function deletePayment($k)
    {
        unset($this->add_payment[$k]);
        unset($this->add_payment_amount[$k]);
        unset($this->add_payment_date[$k]);
        unset($this->add_payment_bank_account_id[$k]);
        $this->emit('changeForm');
        $this->calculate();
    }
}