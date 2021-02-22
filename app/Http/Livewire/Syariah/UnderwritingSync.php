<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;

class UnderwritingSync extends Component
{
    public $total_sync,$is_sync_underwriting,$total_finish=0,$data='Preparing to synchronize, please wait...!',$total_success=0,$total_failed=0;
    protected $listeners = ['emit_sync_underwriting'=>'sync_syariah_uw'];
    public function render()
    {
        return view('livewire.syariah.underwriting-sync');
    }
    public function mount()
    {
        $this->total_sync = \App\Models\SyariahUnderwriting::where(['status'=>1,'is_temp'=>0])->count();
    }
    public function cancel_sync(){
        $this->is_sync_underwriting=false;
        $this->emit('refresh-page');
    }
    public function start_sync(){
        $this->is_sync_underwriting=true;
        $this->sync_syariah_uw();
    }
    public function sync_syariah_uw()
    {
        if($this->is_sync_underwriting==false) return false;
        $this->emit('emit_sync_underwriting');
        foreach(\App\Models\SyariahUnderwriting::where(['status'=>1,'is_temp'=>0])->get() as $key => $item){
            if($key>1) continue;
            $item->status=2;
            $item->save();
            $this->data = $item->no_polis .' - '. $item->pemegang_polis;
            // cek no polis
            $polis = \App\Models\Policy::where('no_polis',$item->no_polis)->first();
            if(!$polis){
                $polis = new \App\Models\Policy();
                $polis->no_polis = $item->no_polis;
                $polis->pemegang_polis = $item->pemegang_polis;
                $polis->cabang = $item->cabang;
                $polis->alamat = $item->alamat;
                $polis->produk = $item->jenis_produk;
                $polis->type = 2; // syariah
                $polis->save();
            }
            // Insert Transaksi
            if(!empty($item->net_kontribusi)){
                // insert income premium receivable
                $income = new \App\Models\Income();
                $income->user_id = \Auth::user()->id;
                $income->no_voucher = generate_no_voucher_income();
                $income->reference_no = $item->no_debit_note;
                $income->reference_date = date('Y-m-d',strtotime($item->tanggal_produksi));
                $income->nominal = $item->net_kontribusi;
                $income->client = $item->pemegang_polis;
                $income->reference_type = 'Premium Receivable';
                $income->transaction_table = 'syariah_underwriting';
                $income->transaction_id = $item->id;
                $income->due_date = $item->tgl_jatuh_tempo;
                $income->type = 2; // Syariah
                $income->save();
                $this->data .= '<br /> Premium Receivable : <strong>'.format_idr($item->net_kontribusi).'</strong>';
            }
            $this->total_success++;
            $this->total_finish++;
        }
        if(\App\Models\SyariahUnderwriting::where(['status'=>1,'is_temp'=>0])->count()==0){
            session()->flash('message-success','Synchronize success, Total Success <strong>'.$this->total_success.'</strong>, Total Failed <strong>'.$this->total_failed.'</strong> !');   
            return redirect()->route('syariah.underwriting');
        }
    }
}