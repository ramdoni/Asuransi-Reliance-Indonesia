<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;

class EndorsementSync extends Component
{
    public $total_sync,$is_sync,$total_finish=0,$data,$total_success=0,$total_failed=0;
    protected $listeners = ['is_sync_endorsement'=>'sync'];
    public function render()
    {
        return view('livewire.syariah.endorsement-sync');
    }
    public function mount()
    {
        $this->total_sync = \App\Models\SyariahEndorsement::where('status',0)->count();
    }
    public function cancel_sync(){
        $this->is_sync=false;
        $this->emit('refresh-page');
    }
    public function sync()
    {
        if($this->is_sync==false) return false;
        $this->emit('is_sync_endorsement');
        foreach(\App\Models\SyariahEndorsement::where(['status'=>0,'is_temp'=>0])->get() as $key => $item){
            if($key > 1) continue;
            $this->data = $item->no_kwitansi_finance .'/'. $item->no_kwitansi_finance2."<br />";
            // find data UW
            $uw = \App\Models\SyariahUnderwriting::where('no_debit_note',$item->no_kwitansi_finance)->orWhere('no_kwitansi_debit_note',$item->no_kwitansi_finance2)->first();   
            if($uw){
                if($uw->status==1) continue; // jika data UW belum di sinkron
                $item->status=1; //sync
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
            
            $this->data = '<strong>Endorsement </strong> : '.format_idr($item->refund);
                
            $this->data .=$item->no_dn_cn.'<br />'.$item->no_polis.' / '.$item->pemegang_polis;
        }
        if(\App\Models\SyariahEndorsement::where('status_sync',0)->count()==0){
            session()->flash('message-success','Synchronize success, Total Success <strong>'.$this->total_success.'</strong>, Total Failed <strong>'.$this->total_failed.'</strong>');   
            return redirect()->route('syariah.underwriting');
        }
    }
}
