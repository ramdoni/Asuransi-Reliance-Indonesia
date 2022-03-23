<?php

namespace App\Http\Livewire\BankBook;

use Livewire\Component;
use App\Models\BankBook;
use App\Models\Income;
use App\Models\ErrorSuspense;

class DetailSettle extends Component
{
    protected $listeners = ['setid'];
    public $bank_book,$vouchers=[],$total_voucher=0,$incomes=[],$error_suspend=[];

    public function render()
    {
        return view('livewire.bank-book.detail-settle');
    }

    public function setid(BankBook $id)
    {
        $this->bank_book = $id;
        $this->vouchers = BankBook::where('bank_book_transaction_id',$this->bank_book->bank_book_transaction_id)->get();
        $this->incomes = Income::where('bank_book_transaction_id',$this->bank_book->bank_book_transaction_id)->get();
        $this->error_suspend = ErrorSuspense::where('bank_book_transaction_id',$this->bank_book->bank_book_transaction_id)->get();
    }
}