<?php

namespace App\Http\Livewire\IncomePremiumReceivable;

use Livewire\Component;

class Detail extends Component
{
    public $data,$no_voucher,$client,$recipient,$reference_type,$reference_no,$reference_date,$description,$outstanding_balance,$tax_id,$payment_amount=0,$bank_account_id,$from_bank_account_id;
    public $payment_date,$tax_amount,$total_payment_amount,$is_readonly=false,$due_date;
    public $bank_charges,$showDetail='underwriting',$cancelation;
    public $titipan_premi,$temp_titipan_premi=[],$temp_arr_titipan_id=[],$total_titipan_premi=0;
    protected $listeners = ['emit-add-bank'=>'emitAddBank','set-titipan-premi'=>'setTitipanPremi','refresh-page'=>'$refresh'];
    public function render()
    {
        return view('livewire.income-premium-receivable.detail');
    }
    public function clearTitipanPremi()
    {
        $this->reset('temp_titipan_premi','temp_arr_titipan_id','total_titipan_premi','from_bank_account_id','bank_account_id');
        $this->emit('init-form');
    }
    public function updated($propertyName)
    {
        $this->outstanding_balance = abs(replace_idr($this->payment_amount) - $this->data->nominal);
        $this->emit('init-form');
    }
    public function setTitipanPremi($id)
    {
        $this->temp_arr_titipan_id[] = $id;
        $this->temp_titipan_premi = \App\Models\Income::whereIn('id',$this->temp_arr_titipan_id)->get();
        $this->total_titipan_premi = 0;
        foreach($this->temp_titipan_premi as $titipan){
            $this->total_titipan_premi += $titipan->outstanding_balance;
        }
        if($this->total_titipan_premi < $this->data->nominal){
            $this->payment_amount = $this->total_titipan_premi;
            $this->outstanding_balance = abs(replace_idr($this->payment_amount) - $this->data->nominal);
        }elseif($this->total_titipan_premi>$this->data->nominal){
            $this->payment_amount = $this->data->nominal;
            $this->outstanding_balance = 0;
        }
        $this->emit('init-form');
    }
    public function emitAddBank($id)
    {
        $this->to_bank_account_id = $id;
        $this->emit('init-form');
    }
    public function mount($id)
    {
        \LogActivity::add("Income - Premium Receivable Edit {$id}");
        $this->data = \App\Models\Income::find($id);
        $this->no_voucher = $this->data->no_voucher;
        $this->payment_date = $this->data->payment_date?$this->data->payment_date : date('Y-m-d');
        $this->bank_account_id = $this->data->rekening_bank_id;
        $this->from_bank_account_id = $this->data->from_bank_account_id;
        $this->payment_amount = $this->data->payment_amount;
        $this->outstanding_balance = $this->data->outstanding_balance;
        $this->description = $this->data->description;
        $this->due_date = $this->data->due_date;
        $this->bank_charges = $this->bank_charges;
        // cek titipan premi
        $this->titipan_premi = \App\Models\IncomeTitipanPremi::where('income_premium_id',$this->data->id)->get();      
        if($this->data->status==1) $this->description = 'Premi ab '. (isset($this->data->uw->pemegang_polis) ? ($this->data->uw->pemegang_polis .' bulan '. $this->data->uw->bulan .' dengan No Invoice :'.$this->data->uw->no_kwitansi_debit_note) : ''); 
        if($this->payment_amount =="") $this->payment_amount=$this->data->nominal;
        if($this->data->status==2 || $this->data->status==4){ $this->is_readonly = true;}
        if($this->data->type==1){ // Konven
            foreach($this->data->cancelation_konven as $cancel) $this->payment_amount -= $cancel->nominal;
            foreach($this->data->endorsement_konven as $endors) $this->payment_amount -= $endors->nominal;
        }
        if($this->data->type==2){ // Syariah
            foreach($this->data->cancelation_syariah as $cancel) $this->payment_amount -= $cancel->nominal;
            foreach($this->data->endorsement_syariah as $endors) $this->payment_amount -= $endors->nominal;
        }    
        $this->payment_amount = format_idr($this->payment_amount);
    }
    public function showDetailCancelation($id)
    {
        if($this->data->type==1) $this->cancelation = \App\Models\KonvenMemo::find($id);
        if($this->data->type==2) $this->cancelation = \App\Models\SyariahCancel::find($id);
        $this->showDetail='cancelation';
        $this->emit('init-form');
    }
    public function save()
    {   
        $this->emit('init-form');
        $validate = ['payment_amount'=>'required'];
        if(!$this->temp_titipan_premi){
            $validate['bank_account_id']='required';
            // $validate['from_bank_account_id']='required';
        }
        $this->validate($validate);
        $this->payment_amount = replace_idr($this->payment_amount);
        $this->bank_charges = replace_idr($this->bank_charges);
        if($this->payment_amount==$this->data->nominal || $this->payment_amount > $this->data->nominal) $this->data->status=2;//paid
        if($this->payment_amount<$this->data->nominal) $this->data->status=3;//outstanding
        $this->data->outstanding_balance = replace_idr($this->outstanding_balance);
        $this->data->payment_amount = $this->payment_amount;
        $this->data->rekening_bank_id = $this->bank_account_id;
        $this->data->payment_date = $this->payment_date;
        $this->data->description = $this->description;
        $this->data->from_bank_account_id = $this->from_bank_account_id;
        $this->data->bank_charges = $this->bank_charges;
        $this->data->user_id = \Auth::user()->id;
        $this->data->save();

        if($this->temp_titipan_premi){
            $total_titipan_premi = 0;
            $nominal_titipan = 0;
            foreach($this->temp_arr_titipan_id as $k => $val){
                $item = \App\Models\Income::find($val);
                $total_titipan_premi += $item->outstanding_balance;            
                if($total_titipan_premi < $this->data->nominal){
                    \App\Models\IncomeTitipanPremi::create([
                        'income_premium_id' => $this->data->id,
                        'income_titipan_id' => $item->id,
                        'nominal' => $item->nominal
                    ]);
                    $item->payment_amount = $item->nominal;
                    $item->outstanding_balance = $item->outstanding_balance - $item->nominal;
                    $item->status = 2;
                }elseif($total_titipan_premi > $this->data->nominal){ // jika sudah melebihi nominal premi, maka status titipan premi jadi completed
                    $total_titipan_premi -= $item->outstanding_balance;
                    \App\Models\IncomeTitipanPremi::create([
                        'income_premium_id' => $this->data->id,
                        'income_titipan_id' => $item->id,
                        'nominal' => ($this->data->nominal - $total_titipan_premi)
                    ]);
                    $item->outstanding_balance = $item->outstanding_balance - ($this->data->nominal - $total_titipan_premi);
                    $item->payment_amount = $item->payment_amount + ($this->data->nominal - $total_titipan_premi);
                }
                $item->save();
            }
        }
        if($this->data->status==2){
            // set balance
            $bank_balance = \App\Models\BankAccount::find($this->data->rekening_bank_id);
            if($bank_balance){
                $bank_balance->open_balance = $bank_balance->open_balance + $this->payment_amount;
                $bank_balance->save();

                $balance = new \App\Models\BankAccountBalance();
                $balance->kredit = $this->payment_amount;
                $balance->bank_account_id = $bank_balance->id;
                $balance->status = 1;
                $balance->type = 4; // Inhouse transfer
                $balance->nominal = $bank_balance->open_balance;
                $balance->transaction_date = $this->payment_date;
                $balance->save();
            }
            $coa_premium_receivable = 0;
            switch($this->data->uw->line_bussines){
                case "JANGKAWARSA":
                    $coa_premium_receivable = 58; //Premium Receivable Jangkawarsa
                break;
                case "EKAWARSA":
                    $coa_premium_receivable = 59; //Premium Receivable Ekawarsa
                break;
                case "DWIGUNA":
                    $coa_premium_receivable = 60; //Premium Receivable Dwiguna
                break;
                case "DWIGUNA KOMBINASI":
                    $coa_premium_receivable = 61; //Premium Receivable Dwiguna Kombinasi
                break;
                case "KECELAKAAN":
                    $coa_premium_receivable = 62; //Premium Receivable Kecelakaan Diri
                break;
                default: 
                    $coa_premium_receivable = 63; //Premium Receivable Other Tradisional
                break;
            }        
            // Premium Receivable
            $journal = new \App\Models\Journal();
            $journal->coa_id = $coa_premium_receivable;
            $journal->no_voucher = generate_no_voucher($coa_premium_receivable,$this->data->id);
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
                $journal->transaction_table = 'income';
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
                $journal->transaction_table = 'income';
                $journal->transaction_number = isset($this->data->uw->no_kwitansi_debit_note)?$this->data->uw->no_kwitansi_debit_note:'';
                $journal->save();
            }
            // Bank
            $coa_bank_account = \App\Models\BankAccount::find($this->bank_account_id);
            if($coa_bank_account and !empty($coa_bank_account->coa_id)){
                $journal = new \App\Models\Journal();
                $journal->coa_id = $coa_bank_account->coa_id;
                $journal->no_voucher = generate_no_voucher($coa_bank_account->coa_id,$this->data->id);
                $journal->date_journal = date('Y-m-d');
                $journal->debit = $this->bank_charges + $this->payment_amount;
                $journal->kredit = 0;
                $journal->saldo = $this->bank_charges + $this->payment_amount;
                $journal->description = $this->description;
                $journal->transaction_id = $this->data->id;
                $journal->transaction_table = 'income';
                $journal->transaction_number = isset($this->data->uw->no_kwitansi_debit_note)?$this->data->uw->no_kwitansi_debit_note:'';
                $journal->save();
            }
        }
        \LogActivity::add("Income - Premium Receivable Save {$this->data->id}");

        session()->flash('message-success',__('Data saved successfully'));
        return redirect()->route('income.premium-receivable');
    }
}