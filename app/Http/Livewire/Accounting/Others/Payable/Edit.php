<?php

namespace App\Http\Livewire\Accounting\Others\Payable;

use Livewire\Component;
use App\Models\Expenses;
use App\Models\Journal;

class Edit extends Component
{
    public $data,$is_readonly = false,$payment_amount,$outstanding_balance,$add_payment=[],$add_payment_temp=[];
    public $no_voucher,$coa_id=[],$type=1;
    public function render()
    {
        return view('livewire.accounting.others.payable.edit');
    }

    public function mount(Expenses $data)
    {
        $this->no_voucher = $data->no_voucher;
        $this->data = $data;
    }

    public function updated($propertyName)
    {
        $this->emit('init-form');    
    }

    public function save()
    {
        $this->emit('init-form');
        
        $arr_validate = [];
        $arr_validate_msg = [];
        foreach($this->data->others_payment as $k => $item){
            $arr_validate['coa_id.'.$k] = 'required';
            $arr_validate_msg['coa_id.'.$k.'.required'] = 'The coa field is required.';
        }
        $arr_validate['type'] = 'required';
        $this->validate($arr_validate,$arr_validate_msg);

        $this->data->status = 1;
        $this->data->save();

        $no_voucher = generate_no_voucer_journal("AP");
        
        foreach($this->data->others_payment as $k => $item){
            $item->coa_id = $this->coa_id[$k];
            $item->save();

            Journal::insert(['coa_id'=>$this->coa_id[$k],'no_voucher'=>$no_voucher,'date_journal'=>date('Y-m-d'),'debit'=>$item->payment_amount,'transaction_id'=>$item->id,'transaction_table'=>'expense_payments']);
        }

        Journal::insert(['coa_id'=>$this->type,'no_voucher'=>$no_voucher,'date_journal'=>date('Y-m-d'),'kredit'=>$this->data->payment_amount,'transaction_id'=>$this->data->id,'transaction_table'=>'expenses']);

        session()->flash('message-success',__('Data has been successfully saved'));
        
        \LogActivity::add("Others Payable {$this->data->id}");

        return redirect()->route('accounting.others');
    }
}