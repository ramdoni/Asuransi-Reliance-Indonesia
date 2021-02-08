<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;
use Livewire\WithPagination;

class Underwriting extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $total_sync=0,$keyword,$status;
    protected $listeners = ['refresh-page'=>'$refresh'];
    public function render()
    {
        $data = \App\Models\SyariahUnderwriting::orderBy('id','DESC')->where('is_temp',0);
        if($this->keyword) $data = $data->where(function($table){
                        foreach(\Illuminate\Support\Facades\Schema::getColumnListing('syariah_underwritings') as $column){
                            $table->orWhere($column,'LIKE',"%{$this->keyword}%");
                        }
                    });
        if($this->status) $data = $data->where('status',$this->status);
        $this->total_sync = \App\Models\SyariahUnderwriting::where(['is_temp'=>0,'status'=>1])->count();
        return view('livewire.syariah.underwriting')->with(['data'=>$data->paginate(100)]);
    }
}
