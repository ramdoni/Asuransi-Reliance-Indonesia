<?php

namespace App\Http\Livewire\Accounting\Others\Receivable;

use Livewire\Component;
use App\Models\Income;
use App\Models\Journal;
use App\Models\IncomeOthersCoa;
use App\Models\CoaGroup;

class Edit extends Component
{
    public $data,$is_readonly = false,$payment_amount,$outstanding_balance,$add_payment=[],$add_payment_temp=[];
    public $no_voucher,$add_coas=[],$coa_id=[],$debit=[],$kredit=[],$description=[],$total_debit=0,$total_kredit=0;
    public $coa_groups=[],$is_save_as_draft=false;
    public $income_others_id=[],$coa_id_temp=[],$description_temp=[],$debit_temp=[],$kredit_temp=[];
    public function render()
    {
        return view('livewire.accounting.others.receivable.edit');
    }

    public function mount(Income $data)
    {
        $this->no_voucher = $data->no_voucher;
        $this->data = $data;
        $this->add();
        $this->coa_groups = CoaGroup::with('coa')->get();
        foreach($data->income_other_coa as $k => $item){
            $this->income_others_id[$k] = $item->id;
            $this->coa_id_temp[$k] = $item->coa_id;
            $this->description_temp[$k] = $item->description;
            $this->debit_temp[$k] = $item->debit;
            $this->kredit_temp[$k] = $item->kredit;
        }        
    }

    public function add()
    {
        $this->add_coas[] = '';$this->coa_id[] = '';$this->debit[]=0;$this->kredit[]=0;$this->description[]='';
        $this->emit('init-form');    
    }

    public function delete_temp($k)
    {
        IncomeOthersCoa::find($this->income_others_id[$k])->delete();

        \LogActivity::add("Others Payable {$this->data->id}");
    
        return redirect()->route('accounting.others');
    }

    public function delete($k)
    {
        unset($this->add_coas[$k],$this->coa_id[$k],$this->debit[$k],$this->kredit[$k],$this->description[$k]);
    }

    public function save_as_draft()
    {
        $this->is_save_as_draft = true;
        $this->save();
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
        foreach($this->income_others_id as $k => $item){
            $temp = IncomeOthersCoa::find($item);
            $temp->coa_id = $this->coa_id_temp[$k];
            $temp->description = $this->description_temp[$k];
            $temp->debit = $this->debit_temp[$k]?$this->debit_temp[$k]:0;
            $temp->kredit = $this->kredit_temp[$k]?$this->kredit_temp[$k]:0;
            $temp->save();
        }

        $this->validate($arr_validate,$arr_validate_msg);
       
        if($this->is_save_as_draft==false){
            $no_voucher = generate_no_voucer_journal("AR");
            $this->data->no_voucher = $no_voucher;
            $this->data->status = 1;
            $this->data->save();
        }

        foreach($this->add_coas as $k => $item){
            if($this->coa_id[$k]=="") continue;
            IncomeOthersCoa::insert([
                'income_id'=>$this->data->id,
                'coa_id'=>$this->coa_id[$k],
                'description'=>$this->description[$k],
                'debit'=>$this->debit[$k]?$this->debit[$k]:0,
                'kredit'=>$this->kredit[$k]?$this->kredit[$k]:0
            ]);
        }

        if($this->is_save_as_draft==false){
            foreach(IncomeOthersCoa::where('income_id',$this->data->id)->get() as $item){
                Journal::insert([
                    'coa_id'=>$item->coa_id,
                    'no_voucher'=>$this->data->no_voucher,
                    'date_journal'=>date('Y-m-d'),
                    'kredit'=>$item->kredit,
                    'debit'=>$item->debit,
                    'description'=>$item->description,
                    'transaction_id'=>$this->data->id,
                    'transaction_table'=>'income',
                    'saldo' => $item->debit ? $item->debit : $item->kredit
                ]);
            }
        }

        session()->flash('message-success',__('Data has been successfully saved'));
        
        \LogActivity::add("Others Payable {$this->data->id}");

        return redirect()->route('accounting.others');
    }
}