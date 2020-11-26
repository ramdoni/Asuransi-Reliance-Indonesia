<?php

namespace App\Http\Livewire\Coa;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $keyword,$coa_group_id;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = \App\Models\Coa::orderBy('id','DESC');
        if($this->keyword) $data = $data->where('code','LIKE', '%'.$this->keyword.'%')
                                                    ->orWhere('name','LIKE', '%'.$this->keyword.'%')
                                                    ->orWhere('description','LIKE', '%'.$this->keyword.'%');
        if($this->coa_group_id) $data = $data->where('coa_group_id',$this->coa_group_id);

        return view('livewire.coa.index')->with(['data'=>$data->paginate(50)]);
    }

    public function delete($id)
    {
        \App\Models\Coa::find($id)->delete();
    }
}
