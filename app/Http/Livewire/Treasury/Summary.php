<?php

namespace App\Http\Livewire\Treasury;

use App\Models\BankAccount;
use App\Models\BankBook;
use App\Models\BankBooksSummary;
use Livewire\Component;

class Summary extends Component
{
    public $filter_month,$filter_year,$years;
    public function render()
    {
        $bank_book = BankBooksSummary::orderBy('date_summary','ASC');

        if($this->filter_month) $bank_book->whereMonth('date_summary',$this->filter_month);
        if($this->filter_year) $bank_book->whereYear('date_summary',$this->filter_year);

        $bank = BankAccount::with('summary')->where('is_client',0)->where('status',1)->get() ;
        
        return view('livewire.treasury.summary')->with(['summary'=>$bank_book->get(),'bank'=>$bank]);
    }

    public function mount()
    {
        $this->filter_month = date('m');
        $this->filter_year = date('Y');
        $this->years = BankBooksSummary::select(\DB::raw('YEAR(date_summary) as year'))->groupBy('year')->get();
    }
}
