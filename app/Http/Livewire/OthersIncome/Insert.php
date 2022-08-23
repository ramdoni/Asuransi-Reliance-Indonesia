<?php

namespace App\Http\Livewire\OthersIncome;

use Livewire\Component;
use App\Models\Income;

class Insert extends Component
{
    public $from_bank_account_id,$type=1,$no_voucher,$client,$reference_type,$reference_no,$reference_date,$description,$description_payment,$nominal,$outstanding_balance=0,$payment_date,$payment_amount=0,$transaction_type;
    public $is_readonly=false,$to_bank_account_id,$is_submit=false;
    public $add_payment,$add_payment_id,$add_payment_amount,$add_payment_description,$add_payment_transaction_type,$data,$bank_charges;
    protected $listeners = ['emit-add-bank'=>'emitAddBank'];
    public function render()
    {
        return view('livewire.others-income.insert');
    }
    public function mount()
    {
        $this->reference_no = "AR-".date('dmy').str_pad((Income::count()+1),6, '0', STR_PAD_LEFT);
        $this->payment_date = date('Y-m-d');
        $this->reference_date = date('Y-m-d');
        $this->add_payment[] = '';
        $this->add_payment_id[]='';
        $this->add_payment_amount[]=0;
        $this->add_payment_description[]='';
        $this->add_payment_transaction_type[]='';
    }
    public function updated($propertyName)
    {
        $this->calculate();
        $this->emit('init-form');    
    }
    public function emitAddBank($id)
    {
        $this->to_bank_account_id = $id;
        $this->emit('init-form');
    }
    public function calculate()
    {
        $this->payment_amount = 0;
        foreach($this->add_payment as $k => $i){
            $this->payment_amount += replace_idr($this->add_payment_amount[$k]);
        }
        $this->outstanding_balance = format_idr(abs(replace_idr($this->payment_amount) - replace_idr($this->nominal)));
    }
    public function save()
    {
        $validate = [];
        $validate_msg = [];
        foreach($this->add_payment as $k => $i){
            $validate["add_payment_amount.{$k}"] = 'required|not_in:0';
            $validate["add_payment_description.{$k}"] = 'required';
            $validate_msg["add_payment_amount.{$k}.not_in"] = 'The Payment Amount field is required.';
            $validate_msg["add_payment_amount.{$k}.required"] = 'The Payment Amount field is required.';
            $validate_msg["add_payment_description.{$k}.required"] = 'The Description field is required.';
        }
        $this->validate($validate,$validate_msg);
                
        $data = new Income();
        $data->no_voucher = $this->no_voucher;
        $data->client = $this->client;
        $data->user_id = \Auth::user()->id;
        $data->reference_type = $this->reference_type;
        $data->reference_date = $this->reference_date;
        $data->description = $this->description;
        $data->nominal = replace_idr($this->payment_amount);
        $data->outstanding_balance = replace_idr($this->outstanding_balance);
        $data->reference_no = "AR/".date('Ym').'/'. str_pad((Income::count()+1),6, '0', STR_PAD_LEFT);
        $data->payment_amount = $this->payment_amount;
        $data->status = 0;
        $data->rekening_bank_id = $this->to_bank_account_id;
        $data->from_bank_account_id = $this->from_bank_account_id;
        $data->is_others = 1;
        // $data->payment_date = $this->payment_date;
        $data->bank_charges = replace_idr($this->bank_charges);
        $data->save();
        
        foreach($this->add_payment as $k =>$i){
            $ex_payment = new \App\Models\IncomePayment();
            $ex_payment->income_id = $data->id;
            $ex_payment->payment_date = $this->payment_date;
            $ex_payment->payment_amount = replace_idr($this->add_payment_amount[$k]);
            $ex_payment->transaction_type = $this->add_payment_transaction_type[$k];
            $ex_payment->description = $this->add_payment_description[$k];
            $ex_payment->save();    
        }
        
        \LogActivity::add("Income Others Submit {$data->id}");
        
        session()->flash('message-success',__('Data saved successfully'));

        return redirect()->route('others-income.index');
    }
    public function addPayment() 
    {
        $this->add_payment[] = '';
        $this->add_payment_amount[] = 0;
        $this->add_payment_description[] = '';
        $this->add_payment_transaction_type[] = '';
        $this->emit('init-form');
    }
    public function delete($k)
    {
        unset($this->add_payment[$k]);
        unset($this->add_payment_amount[$k]);
        unset($this->add_payment_description[$k]);
        unset($this->add_payment_transaction_type[$k]);
        $this->emit('init-form');
        $this->calculate();
    }
}
