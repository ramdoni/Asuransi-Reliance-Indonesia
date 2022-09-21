<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;
use Livewire\WithPagination;

class Underwriting extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword,$status,$total_sync;
    public function render()
    {
        $data = \App\Models\KonvenUnderwriting::orderBy('id','DESC')->where('is_temp',0);
        if($this->keyword) $data->where(function($table){
            foreach(\Illuminate\Support\Facades\Schema::getColumnListing('konven_underwriting') as $column){
                $table->orWhere('konven_underwriting.'.$column,'LIKE',"%{$this->keyword}%");
            }
        });
 
        
        if($this->status) $data = $data->where('status', $this->status);

        return view('livewire.konven.underwriting')->with(['data'=>$data->paginate(100)]);
    }

    public function mount()
    {
        \LogActivity::add('Konven Underwriting');

        $this->total_sync = \App\Models\KonvenUnderwriting::where('status',1)->where('is_temp',0)->count();
    }
}