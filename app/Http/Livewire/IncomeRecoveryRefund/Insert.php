<?php

namespace App\Http\Livewire\IncomeRecoveryRefund;

use Livewire\Component;

class Insert extends Component
{
    public $type=1,$no_voucher,$is_submit=true,$data,$premium_receivable,$no_polis,$outstanding_balance,$reference_no,$payment_amount,$from_bank_account_id,$to_bank_account_id;
    public $is_readonly=false,$payment_date,$bank_charges,$description,$reference_date;
    public $add_pesertas=[],$no_peserta=[],$nama_peserta=[];
    protected $listeners = ['emit-add-bank'=>'emitAddBank'];
    public function render()
    {
        return view('livewire.income-recovery-refund.insert');
    }
    public function mount()
    {
        $this->no_voucher = generate_no_voucher_income();
        $this->payment_date = date('Y-m-d');
        $this->reference_date = date('Y-m-d');
    }
    public function emitAddBank($id)
    {
        $this->from_bank_account_id = $id;
        $this->emit('init-form');
    }
    public function updated($propertyName)
    {
        if($propertyName=='no_polis'){
            $this->data = \App\Models\Policy::find($this->no_polis);
        }
        $this->emit('init-form');
    }
    public function delete_peserta($key)
    {
        unset($this->add_pesertas[$key],$this->no_peserta[$key],$this->nama_peserta[$key]);
    }
    public function add_peserta()
    {
        $this->add_pesertas[] = count($this->add_pesertas);
        $this->no_peserta[] = '';
        $this->nama_peserta[] = '';
    }
    public function save()
    {
        $this->validate([
            'type' => 'required',
            'payment_amount' => 'required'
        ]);
        $this->payment_amount = replace_idr($this->payment_amount);
        $this->bank_charges = replace_idr($this->bank_charges);
        $data = new \App\Models\Income();
        $data->no_voucher = $this->no_voucher;
        $data->reference_type = 'Recovery Refund';
        $data->description = $this->description;
        $data->outstanding_balance = $this->outstanding_balance;
        $data->reference_no = $this->reference_no;
        $data->client = isset($this->data->no_polis) ? $this->data->no_polis .' / '. $this->data->pemegang_polis : '';
        $data->rekening_bank_id = $this->to_bank_account_id;
        $data->from_bank_account_id = $this->from_bank_account_id;
        $data->reference_date = $this->reference_date;
        $data->status = 2;
        $data->user_id = \Auth::user()->id;
        $data->payment_amount = $this->payment_amount;
        $data->bank_charges = $this->bank_charges;
        $data->payment_date = $this->payment_date;
        $data->policy_id = $this->no_polis;
        $data->type = $this->type;
        $data->save();
        if($this->add_pesertas){
            foreach($this->add_pesertas as $k=>$v){
                if(!empty($this->no_peserta[$k]) and !empty($this->nama_peserta[$k])){
                    $peserta = new \App\Models\IncomePeserta();
                    $peserta->income_id = $data->id;
                    $peserta->no_peserta = $this->no_peserta[$k];
                    $peserta->nama_peserta = $this->nama_peserta[$k];
                    $peserta->type = 1; // Recovery Refund
                    $peserta->policy_id = $this->data->id;
                    $peserta->save();
                }
            }
        }

        \LogActivity::add("Income - Recovery Refund Submit {$this->data->id}");

        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('income.recovery-refund');
    }
}
