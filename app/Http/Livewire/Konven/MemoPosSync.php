<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;

class MemoPosSync extends Component
{
    public $total_sync,$is_sync_memo,$total_finish=0,$data;
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
        foreach(\App\Models\KonvenMemo::where('status_sync',0)->get() as $key => $item){
            if($key > 1) continue;
            $this->data = '';
            // find data UW
            $uw = \App\Models\KonvenUnderwriting::where('no_kwitansi_debit_note',$item->no_kwitansi_finance)->orWhere('no_kwitansi_debit_note',$item->no_kwitansi_finance2)->first();   
            if($uw){
                if($uw->status==1) continue; // jika data UW belum di sinkron
                $item->status_sync=1; //sync
                $item->konven_underwriting_id = $uw->id;
            }else{
                $item->status_sync=2;//Invalid
            }
            $item->save();
            // find bank_accounts
            $bank = \App\Models\BankAccount::where('no_rekening',replace_idr($item->no_rekening))->first();
            if(!$bank){
                $bank = new \App\models\BankAccount();
                $bank->bank = $item->bank;
                $bank->no_rekening = replace_idr($item->no_rekening);
                $bank->owner = $item->tujuan_pembayaran;
                $bank->save();
            }
            if($item->jenis_po =='END' and $item->ket_perubahan2=='DN'){ // Endorsment Debit Note
                $this->data = '<strong>Endorsment DN</strong> : '.format_idr($item->refund);
                $income = new \App\Models\Income();
                $income->user_id = \Auth::user()->id;
                $income->no_voucher = generate_no_voucher_income();
                $income->reference_no = $item->no_dn_cn;
                $income->reference_date = $item->tgl_produksi;
                $income->nominal = abs($item->refund);
                $income->client = $item->no_polis.' / '.$item->pemegang_polis;
                $income->reference_type = 'Endorsement';
                $income->transaction_id = $item->id;
                $income->transaction_table = 'konven_memo_pos';
                $income->description = $item->ket_perubahan1;
                $income->rekening_bank_id = $bank->id;
                $income->save();
            }
            if($item->jenis_po =='END' and $item->ket_perubahan2=='CN'){ // Endorsment Credit Note
                $this->data = '<strong>Endorsment CN</strong> : '.format_idr($item->refund);
                $expense = new \App\Models\Expenses();
                $expense->user_id = \Auth::user()->id;
                $expense->no_voucher = generate_no_voucher_income();
                $expense->reference_no = $item->no_dn_cn;
                $expense->reference_date = $item->tgl_produksi;
                $expense->nominal = abs($item->refund);
                $expense->recipient = $item->no_polis.' / '.$item->pemegang_polis;
                $expense->reference_type = 'Endorsement';
                $expense->transaction_id = $item->id;
                $expense->transaction_table = 'konven_memo_pos';
                $expense->description = $item->ket_perubahan1;
                $expense->rekening_bank_id = $bank->id;
                $expense->save();
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
                        $cancel = new \App\Models\KonvenUnderwritingCancelation();
                        $cancel->konven_underwriting_id = $uw->id;
                        $cancel->konven_memo_pos_id = $item->id;
                        $cancel->income_id = $in->id;
                        $cancel->nominal = abs($item->refund);
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
                    $expense->save();
                }
            }
            $this->data .=$item->no_dn_cn.'<br />'.$item->no_polis.' / '.$item->pemegang_polis;
            $this->total_finish++;
        }
        if(\App\Models\KonvenMemo::where('status_sync',0)->count()==0){
            session()->flash('message-success','Synchronize success !');   
            return redirect()->route('konven.underwriting');
        }
    }
}
