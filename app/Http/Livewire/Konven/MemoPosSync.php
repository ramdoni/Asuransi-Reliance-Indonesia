<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;

class MemoPosSync extends Component
{
    public $total_sync,$is_sync_memo,$total_finish=0,$data,$total_success=0,$total_failed=0;
    protected $listeners = ['is_sync_memo'=>'memo_sync'];
    public function render()
    {
        return view('livewire.konven.memo-pos-sync');
    }
    public function mount()
    {
        $this->total_sync = \App\Models\KonvenMemo::where('status_sync',0)->count();
    }
    public function cancel_sync(){
        $this->is_sync_memo=false;
    }
    public function memo_sync()
    {
        if($this->is_sync_memo==false) return false;
        $this->emit('is_sync_memo');
        foreach(\App\Models\KonvenMemo::where(['status_sync'=>0,'is_temp'=>0])->get() as $key => $item){
            if($key > 1) continue;
            $this->data = $item->no_kwitansi_finance .'/'. $item->no_kwitansi_finance2."<br />";
            // find data UW
            $uw = \App\Models\KonvenUnderwriting::where('no_kwitansi_debit_note',$item->no_kwitansi_finance)->orWhere('no_kwitansi_debit_note',$item->no_kwitansi_finance2)->first();   
            if($uw){
                if($uw->status==1) continue; // jika data UW belum di sinkron
                $item->status_sync=1; //sync
                $item->konven_underwriting_id = $uw->id;
                $this->total_success++;
            }else{
                $this->total_failed++;
                $item->status_sync=2;//Invalid
            }
            $item->save();
            $this->total_finish++;
            if(!$uw) continue; // Skip jika tidak ditemukan data UW
            $bank = \App\Models\BankAccount::where('no_rekening',replace_idr($item->no_rekening))->first();
            if(!$bank){
                $bank = new \App\models\BankAccount();
                $bank->bank = $item->bank;
                $bank->no_rekening = replace_idr($item->no_rekening);
                $bank->owner = $item->tujuan_pembayaran;
                $bank->save();
            }
            if($item->jenis_po =='END'){ // Endorsment
                $this->data = '<strong>Endorsment '.$item->ket_perubahan2.'</strong> : '.format_idr($item->refund);
                // cek income Status Unpaid
                $income = \App\Models\Income::where(['transaction_table'=>'konven_underwriting','transaction_id'=>$uw->id,'status'=>1])->first();
                if($income){
                    // $income_end = new \App\Models\KonvenUnderwritingEndorsement();
                    // $income_end->konven_underwriting_id = $uw->id;
                    // $income_end->konven_memo_pos_id = $item->id;
                    // $income_end->income_id = $income->id;
                    // $income_end->nominal = abs($item->refund);
                    // $income_end->type = $item->ket_perubahan2;
                    // $income_end->save();
                    $endors = new \App\Models\IncomeEndorsement();
                    $endors->income_id = $income->id;
                    $endors->nominal =  abs($item->refund);
                    $endors->transaction_table = 'konven_memo_pos';
                    $endors->transaction_id = $item->id;
                    $endors->type = $item->ket_perubahan2 =="DN" ? 2 : 1;
                    $endors->save();
                }else{
                    if($item->ket_perubahan2 =='DN'){
                        $income = new \App\Models\Income();
                        $income->user_id = \Auth::user()->id;
                        $income->no_voucher = generate_no_voucher_income();
                        $income->reference_no = $item->no_dn_cn;
                        $income->reference_date = $item->tgl_produksi;
                        $income->nominal = abs($item->refund);
                        $income->client = $item->no_polis.' / '.$item->pemegang_polis;
                        $income->reference_type = 'Endorsement '.$item->ket_perubahan2;
                        $income->transaction_id = $item->id;
                        $income->transaction_table = 'konven_memo_pos';
                        $income->description = $item->ket_perubahan1;
                        $income->rekening_bank_id = $bank->id;
                        $income->type = 1;
                        $income->save();
                    }else{
                        $expense = new \App\Models\Expenses();
                        $expense->user_id = \Auth::user()->id;
                        $expense->no_voucher = generate_no_voucher_income();
                        $expense->reference_no = $item->no_dn_cn;
                        $expense->reference_date = $item->tgl_produksi;
                        $expense->nominal = abs($item->refund);
                        $expense->recipient = $item->no_polis.' / '.$item->pemegang_polis;
                        $expense->reference_type = 'Endorsement '.$item->ket_perubahan2;
                        $expense->transaction_id = $item->id;
                        $expense->transaction_table = 'konven_memo_pos';
                        $expense->description = $item->ket_perubahan1;
                        $expense->rekening_bank_id = $bank->id;
                        $expense->type = 1;
                        $expense->save();
                    }
                }
            }
            if($item->jenis_po =='RFND'){ // Refund
                $this->data = '<strong>Refund </strong> : '.format_idr($item->refund);
                $expense = new \App\Models\Expenses();
                $expense->user_id = \Auth::user()->id;
                $expense->no_voucher = generate_no_voucher_income();
                $expense->reference_no = $item->no_dn_cn;
                $expense->reference_date = $item->tgl_produksi;
                $expense->nominal = abs($item->refund);
                $expense->recipient = $item->no_polis.' / '.$item->pemegang_polis;
                $expense->reference_type = 'Refund';
                $expense->transaction_id = $item->id;
                $expense->transaction_table = 'konven_memo_pos';
                $expense->description = $item->ket_perubahan1;
                $expense->rekening_bank_id = $bank->id;
                $expense->type = 1;
                $expense->save();
            }
            if($item->jenis_po =='CNCL'){ // Cancel
                $this->data = '<strong>Cancelation </strong> : '.format_idr($item->refund);
                // Find Income Premium Receivable
                if($uw){
                    $in = \App\Models\Income::where('transaction_table','konven_underwriting')->where('transaction_id',$uw->id)->first();
                    if($in and $in->status==1){  
                        //jika statusnya belum paid maka embed cancelation ke form income premium receivable 
                        //dan mengurangi nominal dari premi yang diterima
                        $cancel = new \App\Models\IncomeCancel();
                        $cancel->income_id = $in->id;
                        $cancel->nominal = $item->refund;
                        $cancel->transaction_id = $item->id;
                        $cancel->transaction_table= "konven_memo_pos";
                        $cancel->save();
                    }
                }else{
                    $expense = new \App\Models\Expenses();
                    $expense->user_id = \Auth::user()->id;
                    $expense->no_voucher = generate_no_voucher_income();
                    $expense->reference_no = $item->no_dn_cn;
                    $expense->reference_date = $item->tgl_produksi;
                    $expense->nominal = abs($item->refund);
                    $expense->recipient = $item->no_polis.' / '.$item->pemegang_polis;
                    $expense->reference_type = 'Cancelation';
                    $expense->transaction_id = $item->id;
                    $expense->transaction_table = 'konven_memo_pos';
                    $expense->description = $item->ket_perubahan1;
                    $expense->rekening_bank_id = $bank->id;
                    $expense->type = 1;
                    $expense->save();
                }
            }
            $this->data .=$item->no_dn_cn.'<br />'.$item->no_polis.' / '.$item->pemegang_polis;
        }
        if(\App\Models\KonvenMemo::where('status_sync',0)->count()==0){
            session()->flash('message-success','Synchronize success, Total Success <strong>'.$this->total_success.'</strong>, Total Failed <strong>'.$this->total_failed.'</strong>');   
            return redirect()->route('konven.underwriting');
        }
    }
}
