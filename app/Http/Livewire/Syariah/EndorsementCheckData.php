<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;

class EndorsementCheckData extends Component
{
    public $perpage=100,$keyword;
    protected $listeners = [
                            'emit-check-data-endorsement'=>'$refresh',
                            'delete-all-endorsement' => 'deleteAll'
                        ];
    public function render()
    {
        $data = \App\Models\SyariahEndorsement::orderBy('id','DESC')->where('is_temp',1);
        if($this->keyword) $data = $data->where(function($table){
                                                    foreach(\Illuminate\Support\Facades\Schema::getColumnListing('syariah_endorsement') as $column){
                                                        $table->orWhere($column,'LIKE',"%{$this->keyword}%");
                                                    }
                                                });
        return view('livewire.syariah.endorsement-check-data')->with(['data'=>$data->paginate($this->perpage)]);
    }
    public function deleteAll()
    {
        \App\Models\SyariahEndorsement::where('is_temp',1)->delete();
        $this->emit('refresh-page');
    }
}
