<?php

namespace App\Http\Livewire\ExpenseOthers;

use Livewire\Component;

class Index extends Component
{
    public $keyword;
    public function render()
    {
        $data = \App\Models\Expenses::orderBy('id','DESC')->where('reference_type','!=','Claim');
        return view('livewire.expense-others.index')->with(['data'=>$data->paginate(100)]);
    }
}
