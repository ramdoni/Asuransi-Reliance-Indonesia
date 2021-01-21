<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;

class KomisiSync extends Component
{
    public $total_sync,$is_sync_komisi,$total_finish=0,$data;
    protected $listeners = ['is_sync_komisi'=>'komisi_sync'];
    public function render()
    {
        return view('livewire.konven.komisi-sync');
    }
    public function mount()
    {
        $this->total_sync = \App\Models\KonvenKomisi::where('status',0)->count();
    }
    public function cancel_sync(){
        $this->is_sync_komisi=false;
    }
    public function komisi_sync()
    {
        if($this->is_sync_komisi==false) return false;
        $this->emit('is_sync_komisi');
        foreach(\App\Models\KonvenKomisi::where('status',0)->get() as $key => $item){
            if($key > 1) continue;
            $this->data = '';
            // find data UW
            $uw = \App\Models\KonvenUnderwriting::where('no_kwitansi_debit_note',$item->no_kwitansi)->first();   
            if($uw){
                if($uw->status==1) continue; // jika data UW belum di sinkron
                $item->status=1; //sync
                $item->konven_underwriting_id = $uw->id;
            }else{
                $item->status=2;//Invalid
            }
            $item->save();
            // find bank_accounts
            // $bank = \App\Models\BankAccount::where('no_rekening',$item->no_rekening)->first();
            // if(!$bank){
            //     $bank = new \App\models\BankAccount();
            //     $bank->bank = $item->bank;
            //     $bank->no_rekening = $item->no_rekening;
            //     $bank->owner = $item->tujuan_pembayaran;
            //     $bank->save();
            // }
            $expense = new \App\Models\Expenses();
            $expense->user_id = \Auth::user()->id;
            $expense->no_voucher = generate_no_voucher_income();
            $expense->reference_no = $item->no_kwitansi;
            $expense->reference_date = $item->tgl_invoice;
            $expense->nominal = abs($item->total_komisi);
            $expense->recipient = $item->no_polis.' / '.$item->pemegang_polis;
            $expense->reference_type = 'Komisi';
            $expense->transaction_id = $item->id;
            $expense->transaction_table = 'konven_komisi';
            // $expense->rekening_bank_id = $bank->id;
            $expense->save();

            $this->data .=$item->no_kwitansi.'<br />'.$item->no_polis.' / '.$item->pemegang_polis;
            $this->total_finish++;
        }
        if(\App\Models\KonvenKomisi::where('status',0)->count()==0){
            session()->flash('message-success','Synchronize success !');   
            return redirect()->route('konven.underwriting');
        }
    }
}
