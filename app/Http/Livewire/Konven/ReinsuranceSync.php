<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;

class ReinsuranceSync extends Component
{
    public $total_sync,$is_sync,$total_finish=0,$data;
    protected $listeners = ['is_sync'=>'reas_sync'];
    public function render()
    {
        return view('livewire.konven.reinsurance-sync');
    }
    public function mount()
    {
        $this->total_sync = \App\Models\KonvenReinsurance::where('status',1)->count();
    }
    public function cancel_sync(){
        $this->is_sync=false;
    }
    public function reas_sync()
    {
        if($this->is_sync==false) return false;
        $this->emit('is_sync');
        foreach(\App\Models\KonvenReinsurance::where('status',1)->get() as $key => $item){
            if($key > 1) continue;
            // find UW
            $uw = \App\Models\KonvenUnderwriting::where('no_polis',$item->no_polis)->first();
            $item->konven_underwriting_id = $uw?$uw->id : null;
            $item->status = $uw?2 : 3; // jika ditemukan maka sync jika tidak failed
            $item->save();
            if($uw){ 
                $this->data = $uw->no_polis.' / '.$uw->pemegang_polis;
                if($item->ekawarsa_jangkawarsa=='JANGKAWARSA'){
                    $reinsurance_premium_coa = 224;
                    $komisi_reinsurance_coa = 244;
                    $reinsurance_premium_payable_coa = 168;
                }elseif($item->ekawarsa_jangkawarsa=='EKAWARSA'){
                    $reinsurance_premium_coa = 225;
                    $komisi_reinsurance_coa = 245;
                    $reinsurance_premium_payable_coa = 169;
                }elseif($item->ekawarsa_jangkawarsa=='DWIGUNA'){
                    $reinsurance_premium_coa = 226;
                    $komisi_reinsurance_coa = 246;
                    $reinsurance_premium_payable_coa = 170;
                }else{
                    $reinsurance_premium_coa = 229;
                    $komisi_reinsurance_coa = 249;
                    $reinsurance_premium_payable_coa = 173;
                }
                if($item->komisi_reinsurance){
                    $new  = new \App\Models\Journal();
                    $new->transaction_number = $uw->no_kwitansi_debit_note;
                    $new->transaction_id = $item->id;
                    $new->transaction_table = 'konven_reinsurance'; 
                    $new->coa_id = $komisi_reinsurance_coa;
                    $new->no_voucher = generate_no_voucher($komisi_reinsurance_coa,$item->id);
                    $new->date_journal = date('Y-m-d');
                    $new->debit = 0;
                    $new->kredit = $item->komisi_reinsurance;
                    $new->saldo = $item->komisi_reinsurance;
                    $new->save();
                    // insert Income
                    $income = new \App\Models\Income();
                    $income->user_id = \Auth::user()->id;
                    $income->no_voucher = generate_no_voucher_income();
                    $income->reference_no = $uw->no_kwitansi_debit_note;
                    $income->reference_date = $uw->tanggal_produksi;
                    $income->nominal = $item->komisi_reinsurance;
                    $income->client = $item->pemegang_polis;
                    $income->reference_type = 'Reinsurance';
                    $income->transaction_id = $item->id;
                    $income->transaction_table = 'konven_reinsurance';
                    $income->save();
                }
                if($item->premi_reas_netto){
                    $new  = new \App\Models\Journal();
                    $new->transaction_number = $uw->no_kwitansi_debit_note;
                    $new->transaction_id = $item->id;
                    $new->transaction_table = 'konven_reinsurance'; 
                    $new->coa_id = $reinsurance_premium_payable_coa;
                    $new->no_voucher = generate_no_voucher($reinsurance_premium_payable_coa,$item->id);
                    $new->date_journal = date('Y-m-d');
                    $new->debit = 0;
                    $new->kredit = $item->premi_reas_netto;
                    $new->saldo = $item->premi_reas_netto;
                    $new->save();
                    // insert Income
                    $income = new \App\Models\Income();
                    $income->user_id = \Auth::user()->id;
                    $income->no_voucher = generate_no_voucher_income();
                    $income->reference_no = $uw->no_kwitansi_debit_note;
                    $income->reference_date = $uw->tanggal_produksi;
                    $income->nominal = $item->premi_reas_netto;
                    $income->client = $item->pemegang_polis;
                    $income->reference_type = 'Reinsurance';
                    $income->transaction_id = $item->id;
                    $income->transaction_table = 'konven_reinsurance';
                    $income->save();
                }
                if($item->premi_reas){
                    // insert journal
                    $new  = new \App\Models\Journal();
                    $new->transaction_number = $uw->no_kwitansi_debit_note;
                    $new->transaction_id = $item->id;
                    $new->transaction_table = 'konven_reinsurance'; 
                    $new->coa_id = $reinsurance_premium_coa;
                    $new->no_voucher = generate_no_voucher($reinsurance_premium_coa,$item->id);
                    $new->date_journal = date('Y-m-d');
                    $new->debit = $item->premi_reas;
                    $new->kredit = 0;
                    $new->saldo = $item->premi_reas;
                    $new->save();
                    // insert Income
                    $income = new \App\Models\Income();
                    $income->user_id = \Auth::user()->id;
                    $income->no_voucher = generate_no_voucher_income();
                    $income->reference_no = $uw->no_kwitansi_debit_note;
                    $income->reference_date = $uw->tanggal_produksi;
                    $income->nominal = $item->premi_reas;
                    $income->client = $item->pemegang_polis;
                    $income->reference_type = 'Reinsurance';
                    $income->transaction_id = $item->id;
                    $income->transaction_table = 'konven_reinsurance';
                    $income->save();
                }
            }
            $this->total_finish++;
        }
        if(\App\Models\KonvenReinsurance::where('status',1)->count()==0){
            session()->flash('message-success','Synchronize success !');   
            return redirect()->route('konven.reinsurance');
        }
    }
}