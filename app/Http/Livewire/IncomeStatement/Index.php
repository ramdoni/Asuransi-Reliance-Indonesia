<?php

namespace App\Http\Livewire\IncomeStatement;

use Livewire\Component;
use App\Models\CoaGroup;
use App\Models\IncomeStatement;
use App\Models\Journal;

class Index extends Component
{
    public $data,$tahun;
    public function render()
    {
        $period = IncomeStatement::where('tahun',$this->tahun)->groupBy('bulan')->orderBy('bulan','ASC')->get();

        $data_arr = [];
        // foreach(IncomeStatement::where('tahun',$this->tahun)->get() as $item){
        foreach([1,2,3,4,5,6,7,8,9,10,11,12] as $bulan){

            $journal = Journal::whereYear('created_at',$this->tahun)->whereMonth('created_at',$bulan)->groupBy('coa_id')->get();
            foreach($journal as $item){
                $sum = Journal::whereYear('created_at',$this->tahun)->whereMonth('created_at',$bulan)->where('coa_id',$item->coa_id)->sum('saldo');

                $data_arr[$this->tahun][$bulan][$item->coa_id] = $sum;
            }
        }

        return view('livewire.income-statement.index')->with(['data_arr'=>$data_arr]);
    }

    public function mount()
    {
        $this->tahun = 2022;
        $this->data = CoaGroup::with('coa')->get();
    }
}
