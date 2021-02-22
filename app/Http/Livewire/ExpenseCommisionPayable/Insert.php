<?php

namespace App\Http\Livewire\ExpenseCommisionPayable;

use Livewire\Component;

class Insert extends Component
{
    public $data,$no_voucher,$no_polis,$nilai_klaim,$premium_receivable,$is_submit=true;
    public $reference_no,$payment_date,$bank_charges,$description,$type=1;
    public $to_bank_account_id=[],$from_bank_account_id=[],$transaction_type=[],$payments=[],$payment_amount=[];
    protected $listeners = ['init-form'=>'$refresh'];
    public function render()
    {
        return view('livewire.expense-commision-payable.insert');
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
            $this->is_submit = true;
            $this->premium_receivable = $premium->get();
        }
        $this->emit('init-form');
    }
    public function delete_payment($k){
        unset($this->payments[$k]);
    }
    public function add_payment()
    {
        array_push($this->payments,count($this->payments)+1);
        foreach($this->payments as $k => $v){
            $this->transaction_type[$k] = '';
            $this->payment_amount[$k] = 0;
            $this->from_bank_account_id[$k] = '';
            $this->to_bank_account_id[$k] = '';
        }
        $this->emit('init-form');
    }
    public function submit()
    {
        $this->save('Submit');
    }
    public function save($type)
    {
        $validate = [
            'no_polis' => 'required',
            'reference_no' => 'required',
            'payments' => 'required'
        ];
        $this->validate($validate);
        $data = new \App\Models\Expenses();
        $data->recipient = $this->data->no_polis .' / '. $this->data->pemegang_polis;
        $data->no_voucher = $this->no_voucher;
        $data->reference_no = $this->reference_no;
        $data->type = $this->type;
        $data->status = $type=='Draft' ? 4 : 2;
        $data->reference_type = 'Komisi';
        $data->user_id = \Auth::user()->id;
        $data->policy_id = $this->data->id;
        $data->save();

        if($this->payments){
            foreach($this->payments as $k => $val){
                $payment = new \App\Models\ExpensePayment();
                $payment->expense_id = $data->id;
                $payment->payment_amount = replace_idr($this->payment_amount[$k]);
                $payment->from_bank_account_id = $this->from_bank_account_id[$k];
                $payment->to_bank_account_id = $this->to_bank_account_id[$k];
                $payment->transaction_type = $this->transaction_type[$k];
                $payment->payment_date = $this->payment_date[$k];
                $payment->save();
            }
        }
        \LogActivity::add("Expense - Commision Payable {$type} {$data->id}");
        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('expense.commision-payable');
    }
    public function saveAsDraft()
    {
        $this->save('Draft');
    }
}