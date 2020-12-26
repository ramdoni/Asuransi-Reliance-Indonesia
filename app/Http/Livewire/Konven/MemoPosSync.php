<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;

class MemoPosSync extends Component
{
    public $total_sync,$is_sync,$total_finish=0,$data;
    protected $listeners = ['is_sync'=>'uw_sync'];
    public function render()
    {
        return view('livewire.konven.memo-pos-sync');
    }
    public function mount()
    {
        $this->total_sync = \App\Models\KonvenMemo::where('status_sync',0)->count();
    }
    public function cancel_sync(){
        $this->is_sync=false;
    }
    public function uw_sync()
    {
        if($this->is_sync==false) return false;
        $this->emit('is_sync');
        foreach(\App\Models\KonvenMemo::where('status_sync',0)->get() as $key => $item){
            if($key > 1) continue;
            $item->status=2;
            $item->save();            
            $this->data = '';
           
            if($item->jenis_po =='RFND'){
                $this->data = '<strong>Refund</strong> : ';
                
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
