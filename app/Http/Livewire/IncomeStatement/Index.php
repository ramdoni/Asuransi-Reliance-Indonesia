<?php

namespace App\Http\Livewire\IncomeStatement;

use Livewire\Component;
use App\Models\CoaGroup;
use App\Models\IncomeStatement;

class Index extends Component
{
    public $data,$tahun;
    public function render()
    {
        $period = IncomeStatement::where('tahun',$this->tahun)->groupBy('bulan')->orderBy('bulan','ASC')->get();

        $data_arr = [];
        foreach(IncomeStatement::where('tahun',$this->tahun)->get() as $item){
            $data_arr[$item->tahun][$item->bulan][$item->coa_id] = $item->amount;
        }

        return view('livewire.income-statement.index')->with(['data_arr'=>$data_arr,'period'=>$period]);
    }

    public function mount()
    {
        $this->tahun = date('Y');
        $this->data = CoaGroup::with('coa')->get();
    }
}
