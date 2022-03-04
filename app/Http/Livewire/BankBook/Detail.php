<?php

namespace App\Http\Livewire\BankBook;

use Livewire\Component;
use App\Models\BankBook;

class Detail extends Component
{
    public $active,$data,$generate_no_voucher;
    public $type="P",$to_bank_account_id,$amount,$note,$opening_balance=0;
    public $filter_type,$filter_amount;
    protected $listeners = ['refresh'=>'$refresh'];
    public function render()
    {
        $data = BankBook::where('from_bank_id',$this->data->id)->orderBy('id','DESC');

        if($this->filter_type) $data->where('type',$this->filter_type);
        if($this->filter_amount) $data->where(function($table){
                $max = (int)(0.1*$this->filter_amount)+$this->filter_amount;
                $min = $this->filter_amount - (int)(0.1*$this->filter_amount);
                $table->where('amount','<=',$max)->where('amount','>=',$min);
            });
        $p = clone $data;
        $r = clone $data;
        $a = clone $data;
        $u = clone $data;
        $settle = clone $data;
        $total = clone $data;

        return view('livewire.bank-book.detail')->with(['lists'=>$data->paginate(100), 'total_unidentity'=>$u->where('status',0)->count(), 'total_settle'=>$settle->where('status',1)->count(), 'unidentity'=>$u->where('status',0)->sum('amount'),'total'=>$total->sum('amount'),'total_payable'=>$p->where('type','p')->sum('amount'),'total_receivable'=>$r->where('type','r')->sum('amount'),'total_a'=>$a->where('type','a')->sum('amount')]);
    }

    public function mount($data,$active)
    {
        $this->data = $data;
        $this->active = $active;
        $this->generate_no_voucher = $this->type.str_pad((BankBook::count()+1),8, '0', STR_PAD_LEFT);
        $this->opening_balance = $this->data->open_balance;
    }

    public function updated()
    {
        $this->generate_no_voucher = $this->type.str_pad((BankBook::count()+1),8, '0', STR_PAD_LEFT);
    }

    public function save()
    {
        $this->validate([
            'type'=>'required',
            'to_bank_account_id'=>'required',
            'amount'=>'required',            
        ]);

        $data = new BankBook();
        $data->from_bank_id = $this->data->id;
        $data->type = $this->type;
        $data->to_bank_id = $this->to_bank_account_id;
        $data->amount = $this->amount;
        $data->note = $this->note;
        $data->no_voucher = $this->generate_no_voucher;
        $data->save();
        
        $this->generate_no_voucher = $this->type.str_pad((BankBook::count()+1),8, '0', STR_PAD_LEFT);

        $this->reset(['type','to_bank_account_id','amount','note']);
    }
}