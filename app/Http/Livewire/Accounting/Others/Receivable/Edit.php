<?php

namespace App\Http\Livewire\Accounting\Others\Receivable;

use Livewire\Component;
use App\Models\Income;
use App\Models\Journal;
use App\Models\IncomeOthersCoa;

class Edit extends Component
{
    public $data,$is_readonly = false,$payment_amount,$outstanding_balance,$add_payment=[],$add_payment_temp=[];
    public $no_voucher,$add_coas=[],$coa_id=[],$debit=[],$kredit=[],$description=[],$total_debit=0,$total_kredit=0;
    public function render()
    {
        return view('livewire.accounting.others.receivable.edit');
    }

    public function mount(Income $data)
    {
        $this->no_voucher = $data->no_voucher;
        $this->data = $data;
        $this->add();        
    }

    public function add()
    {
        $this->add_coas[] = '';$this->coa_id[] = '';$this->debit[]=0;$this->kredit[]=0;$this->description[]='';
        $this->emit('init-form');    
    }

    public function updated($propertyName)
    {
        $this->total_debit=0;$this->total_kredit=0;
        foreach($this->add_coas as $k=>$item){
            $this->total_debit += $this->debit[$k]>0?$this->debit[$k]:0;
            $this->total_kredit += $this->kredit[$k]>0?$this->kredit[$k]:0;
        }
        $this->emit('init-form');    
    }

    public function save()
    {
        $this->emit('init-form');
        
        $arr_validate = [];
        $arr_validate_msg = [];
        foreach($this->add_coas as $k => $item){
            $arr_validate['coa_id.'.$k] = 'required';
            $arr_validate_msg['coa_id.'.$k.'.required'] = 'The coa field is required.';
        }
        $this->validate($arr_validate,$arr_validate_msg);
       
        $no_voucher = generate_no_voucer_journal("AR");
        $this->data->no_voucher = $no_voucher;
        $this->data->status = 1;
        $this->data->save();

        foreach($this->add_coas as $k => $item){
            IncomeOthersCoa::insert([
                'income_id'=>$this->data->id,
                'coa_id'=>$this->coa_id[$k],
                'description'=>$this->description[$k],
                'debit'=>$this->debit[$k],
                'kredit'=>$this->kredit[$k]
            ]);

            Journal::insert([
                'coa_id'=>$this->coa_id[$k],
                'no_voucher'=>$no_voucher,
                'date_journal'=>date('Y-m-d'),
                'kredit'=>$this->kredit[$k],
                'debit'=>$this->debit[$k],
                'description'=>$this->description[$k],
                'transaction_id'=>$this->data->id,
                'transaction_table'=>'income'
            ]);
        }

        // Journal::insert(['coa_id'=>152,'no_voucher'=>$no_voucher,'date_journal'=>date('Y-m-d'),'debit'=>$this->data->nominal,'transaction_id'=>$this->data->id,'transaction_table'=>'income']);

        session()->flash('message-success',__('Data has been successfully saved'));
        
        \LogActivity::add("Others Payable {$this->data->id}");

        return redirect()->route('accounting.others');
    }
}