<?php

namespace App\Http\Livewire\IncomeReinsurance;

use Livewire\Component;

class Detail extends Component
{
    public $data,$no_voucher,$client,$recipient,$reference_type,$reference_no,$reference_date,$description,$outstanding_balance,$tax_id,$payment_amount=0,$bank_account_id;
    public $payment_date,$tax_amount,$total_payment_amount,$is_readonly=false,$is_finish=false;
    public $bank_charges,$from_bank_account_id;
    public function render()
    {
        return view('livewire.income-reinsurance.detail');
    }
    public function mount($id)
    {
        $this->data = \App\Models\Income::find($id);
        $this->no_voucher = $this->data->no_voucher;
        $this->payment_date = $this->data->payment_date?$this->data->payment_date : date('Y-m-d');
        $this->bank_account_id = $this->data->rekening_bank_id;
        $this->from_bank_account_id = $this->data->from_bank_account_id;
        $this->payment_amount = format_idr($this->data->payment_amount);
        $this->total_payment_amount = $this->data->total_payment_amount;
        $this->outstanding_balance = $this->data->outstanding_balance;
        
        if($this->data->status==1){
            $this->description = 'Pembayaran Komisi ab '. (isset($this->data->uw->pemegang_polis) ? $this->data->uw->pemegang_polis : ''); 
        }

        if($this->payment_amount =="") $this->payment_amount=format_idr($this->data->nominal);
        if($this->data->status==2) $this->is_finish = true;
     
        \LogActivity::add("Income - Reinsurance Commision Detail {$this->data->id}");
    }
    public function updated($propertyName)
    {
        if($propertyName=='payment_amount') $this->outstanding_balance = $this->data->nominal - replace_idr($this->payment_amount);
        
        $this->emit('init-form');
    }
    public function save()
    {
        $this->validate(
            [
                'bank_account_id'=>'required',
                'payment_amount'=>'required',
                'from_bank_account_id' => 'required'
            ]
        );
        $this->payment_amount = replace_idr($this->payment_amount);
        if($this->payment_amount==$this->data->nominal || $this->payment_amount > $this->data->nominal) $this->data->status=2;//paid
        if($this->payment_amount<$this->data->nominal) $this->data->status=3;//outstanding
        
        $this->data->outstanding_balance = replace_idr($this->outstanding_balance);
        $this->data->payment_amount = $this->payment_amount;
        $this->data->rekening_bank_id = $this->bank_account_id;
        $this->data->from_bank_account_id = $this->from_bank_account_id;
        $this->data->payment_date = $this->payment_date;
        $this->data->description = $this->description;
        $this->data->save();
        if($this->data->status==2){
            $coa_reinsurance_commision = 0;
            switch($this->data->uw->line_bussines){
                case "JANGKAWARSA":
                    $coa_reinsurance_commision = 244; //Reinsurance Commission Fee Jangkawarsa
                break;
                case "EKAWARSA":
                    $coa_reinsurance_commision = 245; //Reinsurance Commission Fee Ekawarsa
                break;
                case "DWIGUNA":
                    $coa_reinsurance_commision = 246; //Reinsurance Commission Fee Dwiguna
                break;
                case "DWIGUNA KOMBINASI":
                    $coa_reinsurance_commision = 247; //Reinsurance Commission Fee Dwiguna Kombinasi
                break;
                case "KECELAKAAN":
                    $coa_reinsurance_commision = 248; //Reinsurance Commission Fee Kecelakaan Diri
                break;
                default: 
                    $coa_reinsurance_commision = 249; //Reinsurance Commission Fee Other Tradisional
                break;
            }        
            // Premium Receivable
            $journal = new \App\Models\Journal();
            $journal->coa_id = $coa_reinsurance_commision;
            $journal->no_voucher = generate_no_voucher($coa_reinsurance_commision,$this->data->id);
            $journal->date_journal = date('Y-m-d');
            $journal->kredit = $this->payment_amount;
            $journal->debit = 0;
            $journal->saldo = $this->payment_amount;
            $journal->description = $this->description;
            $journal->transaction_id = $this->data->id;
            $journal->transaction_table = 'expenses';
            $journal->transaction_number = isset($this->data->uw->no_kwitansi_debit_note)?$this->data->uw->no_kwitansi_debit_note:'';
            $journal->save();

            if($this->payment_amount < $this->data->nominal){
                $journal = new \App\Models\Journal();
                $journal->coa_id = 206;//Other Payable
                $journal->no_voucher = generate_no_voucher(206,$this->data->id);
                $journal->date_journal = date('Y-m-d');
                $journal->kredit = $this->payment_amount - $this->data->nominal;
                $journal->debit = 0;
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
                $journal->kredit = replace_idr($this->bank_charges);
                $journal->debit = 0;
                $journal->saldo = replace_idr($this->bank_charges);
                $journal->description = $this->description;
                $journal->transaction_id = $this->data->id;
                $journal->transaction_table = 'expenses';
                $journal->transaction_number = isset($this->data->uw->no_kwitansi_debit_note)?$this->data->uw->no_kwitansi_debit_note:'';
                $journal->save();
            }
            
            // Bank
            $coa_bank_account = \App\Models\BankAccount::find($this->bank_account_id);
            $journal = new \App\Models\Journal();
            $journal->coa_id = $coa_bank_account->coa_id;
            $journal->no_voucher = generate_no_voucher($coa_bank_account->coa_id,$this->data->id);
            $journal->date_journal = date('Y-m-d');
            $journal->debit = $this->bank_charges + $this->payment_amount;
            $journal->kredit = 0;
            $journal->saldo = $this->bank_charges + $this->payment_amount;
            $journal->description = $this->description;
            $journal->transaction_id = $this->data->id;
            $journal->transaction_table = 'expenses';
            $journal->transaction_number = isset($this->data->uw->no_kwitansi_debit_note)?$this->data->uw->no_kwitansi_debit_note:'';
            $journal->save();
        }

        \LogActivity::add("Income - Reinsurance Commision Submit {$this->data->id}");

        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('income.reinsurance');
    }
}