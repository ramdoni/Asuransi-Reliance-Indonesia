<?php

namespace App\Http\Livewire\ExpenseOthers;

use Livewire\Component;
use App\Models\ExpensePayment;
use App\Models\Expenses;

class Insert extends Component
{
    public $from_bank_account_id,$type=1,$no_voucher,$recipient,$reference_type,$reference_no,$reference_date,$description,$description_payment,$nominal,$outstanding_balance=0,$payment_date,$payment_amount=0,$transaction_type;
    public $is_readonly=false,$to_bank_account_id;
    public $add_payment,$add_payment_id,$add_payment_amount,$add_payment_description,$add_payment_transaction_type;
    protected $listeners = ['emit-add-bank'=>'emitAddBank'];
    public function render()
    {
        return view('livewire.expense-others.insert');
    }
    public function mount()
    {
        $this->no_voucher = generate_no_voucher_expense();
        $this->payment_date = date('Y-m-d');
        $this->reference_date = date('Y-m-d');
        $this->reference_no = "AP-".date('dmy').str_pad((Expenses::count()+1),6, '0', STR_PAD_LEFT);
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
        $this->total_amount = 0;
        foreach($this->add_payment as $k => $i){
            $this->payment_amount += replace_idr($this->add_payment_amount[$k]);
        }
        $this->outstanding_balance = format_idr(abs(replace_idr($this->payment_amount) - replace_idr($this->nominal)));
    }
    public function save($type)
    {
        $this->validate(
            [
                'reference_no' => 'required',
            ],
            [
                'reference_no.required' => 'Credit Note / Kwitansi field is required'
            ]
        );

        $data = new Expenses();
        $data->no_voucher = $this->no_voucher;
        $data->recipient = $this->recipient;
        $data->user_id = \Auth::user()->id;
        $data->reference_type = $this->reference_type;
        $data->reference_date = $this->reference_date;
        $data->description = $this->description;
        $data->reference_no = $this->reference_no;
        $data->payment_amount = $this->payment_amount;
        $data->status = 0;
        $data->is_others = 1;
        $data->save();

        foreach($this->add_payment as $k =>$i){
            ExpensePayment::insert([
                'expense_id' => $data->id,
                'payment_amount' =>  replace_idr($this->add_payment_amount[$k]),
                'transaction_type' =>  $this->add_payment_transaction_type[$k],
                'description' => $this->add_payment_description[$k]
            ]);
        }

        \LogActivity::add("Expense Others Submit {$data->id}");
        
        session()->flash('message-success',__('Data saved successfully'));

        return redirect()->route('expense.others');
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
