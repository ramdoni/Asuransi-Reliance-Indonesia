<?php

namespace App\Http\Livewire\ExpenseCancelation;

use Livewire\Component;

class Detail extends Component
{
    public $data,$no_voucher,$client,$recipient,$reference_type,$reference_no,$reference_date,$description,$outstanding_balance,$tax_id,$payment_amount=0,$bank_account_id,$from_bank_account_id;
    public $payment_date,$tax_amount,$total_payment_amount,$is_readonly=false,$is_finish=false,$paid_premi=1,$paid_premi_id;
    public $bank_charges;
    public function render()
    {
        return view('livewire.expense-cancelation.detail');
    }
    public function mount($id)
    {
        $this->data = \App\Models\Expenses::find($id);
        $this->no_voucher = $this->data->no_voucher;
        $this->payment_date = $this->data->payment_date?$this->data->payment_date : date('Y-m-d');
        $this->bank_account_id = $this->data->rekening_bank_id;
        $this->payment_amount = format_idr($this->data->payment_amount);
        $this->total_payment_amount = $this->data->total_payment_amount;
        $premi = \App\Models\Income::where('transaction_id',$this->data->uw->id)->where('transaction_table','konven_underwriting')->first();
        if($premi){
            $this->paid_premi = $premi->status;
            $this->paid_premi_id =$premi->id;
            if($premi->status!=2) $this->is_readonly = true;
        }
        if($this->payment_amount =="") $this->payment_amount=$this->data->nominal;
        if($this->data->status==2) $this->is_finish = true;
    }
    public function save()
    {
        // if($this->is_finish) return false;
        $this->validate(
            [
                'bank_account_id'=>'required',
                'from_bank_account_id'=>'required',
                'payment_amount'=>'required',
            ]
        );
        $this->payment_amount = replace_idr($this->payment_amount);
        if($this->payment_amount==$this->data->nominal) $this->data->status=2;//paid
        if($this->payment_amount!=$this->data->nominal) $this->data->status=3;//outstanding
        $this->data->outstanding_balance = replace_idr($this->outstanding_balance);
        $this->data->payment_amount = $this->payment_amount;
        $this->data->rekening_bank_id = $this->bank_account_id;
        $this->data->payment_date = $this->payment_date;
        $this->data->save();
        if($this->data->status==2){
            if($this->data->transaction_table=='konven_reinsurance'){
                $reas = \App\Models\KonvenReinsurance::find($this->data->transaction_id);
                $coa_reinsurance_premium_payable = 0;
                switch($reas->ekawarsa_jangkawarsa){
                    case "JANGKAWARSA":
                        $coa_reinsurance_premium_payable = 168;
                    break;
                    case "EKAWARSA":
                        $coa_reinsurance_premium_payable = 169;
                    break;
                    case "DWIGUNA":
                        $coa_reinsurance_premium_payable = 170;
                    break;
                    case "DWIGUNA KOMBINASI":
                        $coa_reinsurance_premium_payable = 171;
                    break;
                    case "KECELAKAAN":
                        $coa_reinsurance_premium_payable = 172;
                    break;
                    default: 
                        $coa_reinsurance_premium_payable = 173; // Others Tradisional
                    break;
                }    
            }
            $coa_bank_charges = 347;
            // Bank
            $coa_bank_account = \App\Models\BankAccount::find($this->bank_account_id);
            $journal = new \App\Models\Journal();
            $journal->coa_id = $coa_bank_account->coa_id;
            $journal->no_voucher = generate_no_voucher($coa_bank_account->coa_id,$this->data->id);
            $journal->date_journal = date('Y-m-d');
            $journal->kredit = $this->bank_charges + $this->payment_amount;
            $journal->debit = 0;
            $journal->saldo = $this->bank_charges + $this->payment_amount;
            $journal->description = $this->description ? $this->description : 'Pembayaran Premi Reas '.$reas->broker_re.' ('.$reas->keterangan.')';
            $journal->transaction_id = $this->data->id;
            $journal->transaction_table = 'expenses';
            $journal->transaction_number = isset($reas->uw->no_kwitansi_debit_note)?$reas->uw->no_kwitansi_debit_note:'';
            $journal->save();
            // Bank Charges
            if(!empty($this->bank_charges)){
                $journal = new \App\Models\Journal();
                $journal->coa_id = $coa_bank_charges;
                $journal->no_voucher = generate_no_voucher($coa_bank_charges,$this->data->id);
                $journal->date_journal = date('Y-m-d');
                $journal->debit = replace_idr($this->bank_charges);
                $journal->kredit = 0;
                $journal->saldo = replace_idr($this->bank_charges);
                $journal->description = $this->description ? $this->description : 'Pembayaran Premi Reas '.$reas->broker_re.' ('.$reas->keterangan.')';
                $journal->transaction_id = $this->data->id;
                $journal->transaction_table = 'expenses';
                $journal->transaction_number = isset($reas->uw->no_kwitansi_debit_note)?$reas->uw->no_kwitansi_debit_note:'';
                $journal->save();
            }
            // Reinsurance Premium Payable
            $journal = new \App\Models\Journal();
            $journal->coa_id = $coa_reinsurance_premium_payable;
            $journal->no_voucher = generate_no_voucher($coa_reinsurance_premium_payable,$this->data->id);
            $journal->date_journal = date('Y-m-d');
            $journal->debit = $this->payment_amount;
            $journal->kredit = 0;
            $journal->saldo = $this->payment_amount;
            $journal->description = $this->description ? $this->description : 'Pembayaran Premi Reas '.$reas->broker_re.' ('.$reas->keterangan.')';
            $journal->transaction_id = $this->data->id;
            $journal->transaction_table = 'expenses';
            $journal->transaction_number = isset($reas->uw->no_kwitansi_debit_note)?$reas->uw->no_kwitansi_debit_note:'';
            $journal->save();
        }
        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('expense.reinsurance-premium');
    }
}