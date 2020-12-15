<?php

namespace App\Http\Livewire\Policy;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $keyword;
    public function render()
    {
        $data = \App\Models\Policy::orderBy('id','desc');
        if($this->keyword) $data = $data->where('no_polis','LIKE',"%{$this->keyword}%")
                                        ->orWhere('pemegang_polis','LIKE',"%{$this->keyword}%")
                                        ->orWhere('alamat','LIKE',"%{$this->keyword}%")
                                        ->orWhere('produk','LIKE',"%{$this->keyword}%");
        return view('livewire.policy.index')->with(['data'=>$data->paginate(50)]);
    }
    public function delete($id)
    {
        \App\Models\Policy::find($id)->delete();
    }
}