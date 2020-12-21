<?php

namespace App\Http\Livewire\ExpenseOthers;

use Livewire\Component;

class Insert extends Component
{
    public $no_voucher,$recipient,$reference_type,$reference_no,$reference_date,$description,$description_payment,$nominal,$outstanding_balance=0,$payment_date,$payment_amount=0,$payment_type,$transaction_type;
    public $total_payment_amount,$is_readonly=false;
    public $add_payment=[],$add_payment_id=[],$add_payment_amount,$add_payment_description,$add_payment_transaction_type;
    public function render()
    {
        return view('livewire.expense-others.insert');
    }
    public function mount()
    {
        $this->no_voucher = generate_no_voucher_expense();
        $this->payment_date = date('Y-m-d');
        $this->reference_date = date('Y-m-d');
    }
    public function calculate()
    {
        $this->total_payment_amount =  replace_idr($this->payment_amount);
        foreach($this->add_payment as $k => $i){
            $this->total_payment_amount += replace_idr($this->add_payment_amount[$k]);
        }
        $this->outstanding_balance = format_idr(abs(replace_idr($this->total_payment_amount) - replace_idr($this->nominal)));
    }
    public function save()
    {
        $this->validate(
            [
                'recipient' => 'required',
                'reference_type' => 'required',
                'reference_no' => 'required',
                'reference_date' => 'required',
                'nominal' => 'required',
                'payment_amount' => 'required',
                'payment_date'=>'required',
                'payment_type'=>'required'
            ]
        );

        $this->nominal = replace_idr($this->nominal);
        $this->outstanding_balance = replace_idr($this->outstanding_balance);
        $this->payment_amount = replace_idr($this->payment_amount);
        $this->total_payment_amount = replace_idr($this->total_payment_amount);

        if($this->total_payment_amount==$this->nominal || $this->total_payment_amount>$this->nominal) $status=2; // Paid
        if($this->total_payment_amount<$this->nominal) $status=3; // Outstanding
        
        $data = new \App\Models\Expenses();
        $data->no_voucher = $this->no_voucher;
        $data->recipient = $this->recipient;
        $data->user_id = \Auth::user()->id;
        $data->reference_type = $this->reference_type;
        $data->reference_date = $this->reference_date;
        $data->description = $this->description;
        $data->nominal = replace_idr($this->nominal);
        $data->outstanding_balance = replace_idr($this->outstanding_balance);
        $data->reference_no = $this->reference_no;
        $data->payment_amount = $this->payment_amount;
        $data->status = $status;
        $data->rekening_bank_id = $this->payment_type;
        $data->is_others = 1;
        $data->save();
        foreach($this->add_payment as $k =>$i){
            $ex_payment = new \App\Models\ExpensePayment();
            $ex_payment->expense_id = $data->id;
            $ex_payment->payment_date = $this->payment_date;
            $ex_payment->payment_amount = replace_idr($this->add_payment_amount[$k]);
            $ex_payment->transaction_type = $this->add_payment_transaction_type[$k];
            $ex_payment->save();
        }
        if($status==2){
            // insert Journal
            if(isset($data->bank_account->coa->id)){
                $new  = new \App\Models\Journal();
                $new->transaction_number = $data->reference_no;
                $new->transaction_id = $data->id;
                $new->transaction_table = 'expenses'; 
                $new->coa_id = $data->bank_account->coa->id;
                $new->no_voucher = generate_no_voucher($data->bank_account->coa->id,$data->id);
                $new->date_journal = date('Y-m-d');
                $new->kredit = $this->total_payment_amount;
                $new->debit = 0;
                $new->saldo = $this->total_payment_amount;
                $new->description = $this->description;
                $new->save();
            }
            // insert Journal
            $new  = new \App\Models\Journal();
            $new->transaction_number = $data->reference_no;
            $new->transaction_id = $data->id;
            $new->transaction_table = 'expenses'; 
            $new->coa_id = $this->transaction_type;
            $new->no_voucher = generate_no_voucher($this->transaction_type,$data->id);
            $new->date_journal = date('Y-m-d');
            $new->debit = $this->payment_amount;
            $new->kredit = 0;
            $new->saldo = $this->payment_amount;
            $new->description = $this->description_payment;
            $new->save();
            foreach($this->add_payment as $k =>$i){
                // insert Journal
                $new  = new \App\Models\Journal();
                $new->transaction_number = $data->reference_no;
                $new->transaction_id = $data->id;
                $new->transaction_table = 'expenses'; 
                $new->coa_id = $this->add_payment_transaction_type[$k];
                $new->no_voucher = generate_no_voucher($this->add_payment_transaction_type[$k],$data->id);
                $new->date_journal = date('Y-m-d');
                $new->debit = replace_idr($this->add_payment_amount[$k]);
                $new->kredit = 0;
                $new->saldo = replace_idr($this->add_payment_amount[$k]);
                $new->description = $this->add_payment_description[$k];
                $new->save();
            }
        }
        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('expense.others');
    }
    public function addPayment() 
    {
        $this->add_payment[] = '';
        $this->add_payment_amount[] = 0;
        $this->add_payment_description[] = '';
        $this->add_payment_transaction_type[] = '';
        $this->emit('changeForm');
    }
    public function deletePayment($k)
    {
        unset($this->add_payment[$k]);
        unset($this->add_payment_amount[$k]);
        unset($this->add_payment_description[$k]);
        unset($this->add_payment_transaction_type[$k]);
        $this->emit('changeForm');
        $this->calculate();
    }
}
