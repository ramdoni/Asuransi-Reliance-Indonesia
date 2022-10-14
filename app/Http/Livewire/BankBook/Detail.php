<?php

namespace App\Http\Livewire\BankBook;

use Livewire\Component;
use App\Models\BankBook;
use App\Models\BankAccount;
use Livewire\WithPagination;

class Detail extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $active,$data,$generate_no_voucher,$is_first;
    public $type="P",$to_bank_account_id,$amount,$note,$opening_balance=0,$status;
    public $filter_type,$filter_amount,$payment_date,$date_from,$date_to,$filter_propose;
    protected $listeners = ['refresh'=>'$refresh','set_active'=>'set_active'];
    public function render()
    {
        if(isset($this->data->id) and $this->data->id == $this->active){
            $data = BankBook::with(['adjustment'])->where('from_bank_id',$this->data->id)->orderBy('id','DESC');

            if($this->filter_type) $data->where('type',$this->filter_type);
            if($this->status) $data->where('status',$this->status);
            if($this->filter_amount) $data->where(function($table){
                    $max = (int)(0.1*$this->filter_amount)+$this->filter_amount;
                    $min = $this->filter_amount - (int)(0.1*$this->filter_amount);
                    $table->where('amount','<=',$max)->where('amount','>=',$min);
                });
            if($this->filter_propose) $data->where('propose',$this->filter_propose);
            if($this->date_from and $this->date_to) {
                if($this->date_from == $this->date_to)
                    $data->whereDate('payment_date',$this->date_from);
                else
                    $data->whereBetween('payment_date',[$this->date_from,$this->date_to]);
            }

            $p = clone $data;
            $r = clone $data;
            $a = clone $data;
            $u = clone $data;
            $settle = clone $data;
            $total = clone $data;
            
            $this->opening_balance = isset($this->data->open_balance) ? $this->data->open_balance : '0';

            return view('livewire.bank-book.detail')->with(['lists'=>$data->paginate(100), 
                                                            'total_unidentity'=>$u->where('status',0)->count(), 
                                                            'total_settle'=>$settle->where('status',1)->count(), 
                                                            'unidentity'=>$u->where('status',0)->sum('amount'),
                                                            'total'=>$total->sum('amount'),
                                                            'total_payable'=>$p->where('type','p')->sum('amount'),
                                                            'total_receivable'=>$r->where('type','r')->sum('amount'),
                                                            'total_a'=>$a->where('type','a')->sum('amount')]);
        }else  return view('livewire.bank-book.detail');    
    }

    public function reset_filter()
    {
        $this->reset(['date_from','date_to','filter_type','status','filter_amount']);
    }

    public function set_active($id)
    {
        $this->active = $id;
        $this->data = BankAccount::find($id);
    }

    public function mount($active)
    {
        // $this->data = $data;
        $this->active = $active;
        $this->generate_no_voucher = $this->type.str_pad((BankBook::count()+1),8, '0', STR_PAD_LEFT);
        // $this->is_first = $is_first;
    }

    public function updated($propertyName)
    {
        $this->generate_no_voucher = $this->type.str_pad((BankBook::count()+1),8, '0', STR_PAD_LEFT);
        $this->emit('init-form');
    }

    public function delete(BankBook $id)
    {
        \LogActivity::add("Bank Book - Delete #{$id->id}");

        $id->delete();
        $this->emit('message-success','Data deleted successfully');
    }
}