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

        return view('livewire.policy.index')->with(['data'=>$data->paginate(50)]);
    }
}
