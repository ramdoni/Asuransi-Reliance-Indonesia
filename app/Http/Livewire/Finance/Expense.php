<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;

class Expense extends Component
{
    public $keyword;
    public function render()
    {
        $data = \App\Models\Expenses::orderBy('id','DESC')->where('is_others',1);

        return view('livewire.finance.expense')->with(['data'=>$data->paginate(100)]);
    }
}
