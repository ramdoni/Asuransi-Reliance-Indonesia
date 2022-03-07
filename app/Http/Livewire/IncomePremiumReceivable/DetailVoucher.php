<?php

namespace App\Http\Livewire\IncomePremiumReceivable;

use Livewire\Component;
use App\Models\BankBookPairing;
use App\Models\BankBook;

class DetailVoucher extends Component
{
    public $data=[],$voucher;
    protected $listeners = ['set-voucher'=>'setVoucher'];
    public function render()
    {
        return view('livewire.income-premium-receivable.detail-voucher');
    }

    public function setVoucher(BankBook $id)
    {
        $this->voucher = $id;
        $this->data = BankBookPairing::where('bank_book_id',$id->id)->orderBy('id','DESC')->get();
    }
}
