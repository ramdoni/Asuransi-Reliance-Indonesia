<?php

namespace App\Http\Livewire\BankBook;

use Livewire\Component;
use App\Models\BankBook;

class InsertSettle extends Component
{
    public $type,$premium_receivable=[],$bank_book_id=[];
    protected $listeners = ['set_bank_book'];
    public function render()
    {
        return view('livewire.bank-book.insert-settle');
    }

    public function  set_bank_book($id)
    {
        $this->bank_book_id = BankBook::whereIn('id',$id)->get();
    }
}
