<?php

namespace App\Http\Livewire\BankBook;

use Livewire\Component;
use App\Models\BankBook;
use App\Models\Income;
use Livewire\WithPagination;

class Teknik extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $check_id=[],$type,$transaction_id,$premium_receivable=[];

    public function render()
    {
        $data = BankBook::orderBy('id','desc');

        return view('livewire.bank-book.teknik')->with(['data'=>$data->paginate(100)]);
    }

    public function mount()
    {
        $this->premium_receivable = Income::where('reference_type','Premium Receivable')->get();
    }

    public function updated($propertyName)
    {
        if($propertyName=='type'){
            $this->emit('select-premium-receivable');
        }
    }
}
