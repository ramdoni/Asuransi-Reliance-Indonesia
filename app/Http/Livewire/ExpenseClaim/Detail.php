<?php

namespace App\Http\Livewire\ExpenseClaim;

use Livewire\Component;

class Detail extends Component
{
    public $data,$no_voucher,$client,$recipient,$reference_type,$reference_no,$reference_date,$description,$outstanding_balance,$tax_id,$payment_amount=0,$bank_account_id;
    public $payment_date,$tax_amount,$total_payment_amount,$is_readonly=false,$is_finish=false;
    public $bank_charges,$from_bank_account_id;
    protected $listeners = ['emit-add-bank'=>'emitAddBank'];
    public function render()
    {
        return view('livewire.expense-claim.detail');
    }
    public function mount($id)
    {
        $this->data = \App\Models\Expenses::find($id);
        $this->no_voucher = $this->data->no_voucher;
        $this->payment_date = $this->data->payment_date?$this->data->payment_date : date('Y-m-d');
        $this->bank_account_id = $this->data->rekening_bank_id;
        $this->payment_amount = format_idr($this->data->payment_amount);
        $this->total_payment_amount = $this->data->total_payment_amount;
        
        if($this->data->status==1){
            $this->description = 'Pembayaran Klaim an '. (isset($this->data->claim->nama_partisipan) ? $this->data->claim->nama_partisipan .' ab '. $this->data->claim->nama_pemegang : ''); 
        }

        if($this->payment_amount =="") $this->payment_amount=$this->data->nominal;
        if($this->data->status==2) $this->is_readonly = true;
    }
    public function updated($propertyName)
    {
        $this->payment_amount = $this->payment_amount + replace_idr($this->bank_charges);
        $this->emit('init-form');
    }
    public function emitAddBank($id)
    {
        $this->bank_account_id = $id;
        $this->emit('init-form');
    }
    public function save()
    {
        $this->validate(
            [
                'bank_account_id'=>'required',
                'from_bank_account_id'=>'required',
                'payment_amount'=>'required',
            ]
        );
        $this->payment_amount = replace_idr($this->payment_amount);
        $this->bank_charges = replace_idr($this->bank_charges);
        if($this->payment_amount==$this->data->nominal || $this->payment_amount > $this->data->nominal) $this->data->status=2;//paid
        if($this->payment_amount<$this->data->nominal) $this->data->status=3;//outstanding
        
        $this->data->outstanding_balance = replace_idr($this->outstanding_balance);
        $this->data->payment_amount = $this->payment_amount;
        $this->data->rekening_bank_id = $this->bank_account_id;
        $this->data->from_bank_account_id = $this->from_bank_account_id;
        $this->data->payment_date = $this->payment_date;
        $this->data->description = $this->description;
        $this->data->bank_charges = $this->bank_charges;
        $this->data->save();
        if($this->data->status==2){
            $coa_claim_payable = 0;
            switch($this->data->uw->line_bussines){
                case "JANGKAWARSA":
                    $coa_claim_payable = 155; //Claim Payable Jangkawarsa
                break;
                case "EKAWARSA":
                    $coa_claim_payable = 156; //Claim Payable Ekawarsa
                break;
                case "DWIGUNA":
                    $coa_claim_payable = 157; //Claim Payable Dwiguna
                break;
                case "DWIGUNA KOMBINASI":
                    $coa_claim_payable = 158; //Claim Payable Dwiguna Kombinasi
                break;
                case "KECELAKAAN":
                    $coa_claim_payable = 159; //Claim Payable Kecelakaan Diri
                break;
                default: 
                    $coa_claim_payable = 160; //Claim Payable Other Tradisional
                break;
            }        
            // Bank
            $coa_bank_account = \App\Models\BankAccount::find($this->bank_account_id);
            if($coa_bank_account and !empty($coa_bank_account->coa_id)){
                $journal = new \App\Models\Journal();
                $journal->coa_id = $coa_bank_account->coa_id;
                $journal->no_voucher = generate_no_voucher($coa_bank_account->coa_id,$this->data->id);
                $journal->date_journal = date('Y-m-d');
                $journal->kredit = $this->bank_charges + $this->payment_amount;
                $journal->debit = 0;
                $journal->saldo = $this->bank_charges + $this->payment_amount;
                $journal->description = $this->description;
                $journal->transaction_id = $this->data->id;
                $journal->transaction_table = 'expenses';
                $journal->transaction_number = isset($this->data->uw->no_kwitansi_debit_note)?$this->data->uw->no_kwitansi_debit_note:'';
                $journal->save();
            }

            if($this->payment_amount > $this->data->nominal){
                $journal = new \App\Models\Journal();
                $journal->coa_id = 206;//Other Payable
                $journal->no_voucher = generate_no_voucher(206,$this->data->id);
                $journal->date_journal = date('Y-m-d');
                $journal->debit = $this->payment_amount - $this->data->nominal;
                $journal->kredit = 0;
                $journal->saldo = $this->payment_amount - $this->data->nominal;
                $journal->description = $this->description;
                $journal->transaction_id = $this->data->id;
                $journal->transaction_table = 'expenses';
                $journal->transaction_number = isset($this->data->uw->no_kwitansi_debit_note)?$this->data->uw->no_kwitansi_debit_note:'';
                $journal->save();
            }
            // Bank Charges
            if(!empty($this->bank_charges)){
                $journal = new \App\Models\Journal();
                $journal->coa_id = 347; // Bank Charges
                $journal->no_voucher = generate_no_voucher(347,$this->data->id);
                $journal->date_journal = date('Y-m-d');
                $journal->debit = $this->bank_charges;
                $journal->kredit = 0;
                $journal->saldo = $this->bank_charges;
                $journal->description = $this->description;
                $journal->transaction_id = $this->data->id;
                $journal->transaction_table = 'expenses';
                $journal->transaction_number = isset($this->data->uw->no_kwitansi_debit_note)?$this->data->uw->no_kwitansi_debit_note:'';
                $journal->save();
            }
            // Reinsurance Premium Payable
            $journal = new \App\Models\Journal();
            $journal->coa_id = $coa_claim_payable;
            $journal->no_voucher = generate_no_voucher($coa_claim_payable,$this->data->id);
            $journal->date_journal = date('Y-m-d');
            $journal->debit = $this->payment_amount;
            $journal->kredit = 0;
            $journal->saldo = $this->payment_amount;
            $journal->description = $this->description;
            $journal->transaction_id = $this->data->id;
            $journal->transaction_table = 'expenses';
            $journal->transaction_number = isset($this->data->uw->no_kwitansi_debit_note)?$this->data->uw->no_kwitansi_debit_note:'';
            $journal->save();
        }
        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('expense.claim');
    }
}