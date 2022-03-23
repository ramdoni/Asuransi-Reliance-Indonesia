<?php

namespace App\Http\Livewire\BankBook;

use Livewire\Component;
use App\Models\BankBook;
use App\Models\BankBookSettle;
use App\Models\BankBookTransaction;
use App\Models\Income;
use App\Models\ErrorSuspense;

class InsertSettle extends Component
{
    public $types=[],$transaction_ids=[],$bank_book_id=[],$kwitansi = [];
    public $payment_ids=[],$amounts=[],$total_payment=0,$total_voucher=0,$message_error = '';
    protected $listeners = ['set_bank_book'];
    public function render()
    {
        return view('livewire.bank-book.insert-settle');
    }

    public function updated($propertyName)
    {
        $this->emit('select-type',$this->transaction_ids);
    }

    public function  set_bank_book($id)
    {
        $this->bank_book_id = BankBook::whereIn('id',$id)->get();
    }

    public function add_payment()
    {
        $this->payment_ids[] = null;
        $this->types[] = null;
        $this->transaction_ids[] = null;
        $this->amounts[] = 0;
        $this->emit('select-type');
    }

    public function delete_payment($k)
    {
        unset($this->payment_ids[$k],$this->types[$k],$this->transaction_ids[$k],$this->amounts[$k]);
        $this->emit('select-type');
    }

    public function save()
    {
        if($this->total_payment != $this->total_voucher){ 
            $this->message_error = '';
            return false;
        }

        $transaction  = new BankBookTransaction();
        $transaction->amount  = $this->total_voucher;
        $transaction->save();

        foreach($this->bank_book_id as $bank_book){
            $bank_book->date_pairing = date('Y-m-d');
            $bank_book->bank_book_transaction_id = $transaction->id;
            $bank_book->status = 1;
            $bank_book->save();
        }

        foreach($this->types as $k => $item){
            if($item=='Premium Receivable' || $item=='Reinsurance Premium'){
               $income = Income::find($this->transaction_ids[$k]);
               if($income) {
                   $income->status = 2;
                   $income->bank_book_transaction_id = $transaction->id;
                   $income->payment_date = $bank_book->payment_date;
                   $income->save();
               }
            }
            if($item=='Error Suspense Account'){
                $error = new ErrorSuspense();
                $error->bank_book_transaction_id = $transaction->id;
                $error->amount = $this->amounts[$k];
                $error->note = $this->transaction_ids[$k];
                $error->save();
            }
        }

        session()->flash('message-success',__('Settle successfully'));

        return redirect()->route('bank-book.teknik');
    }
}
