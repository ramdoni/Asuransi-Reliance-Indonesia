<?php

namespace App\Http\Livewire\BankBook;

use Livewire\Component;
use App\Models\BankBook;
use App\Models\Income;
use Livewire\WithPagination;

class Teknik extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap',$listeners = ['reload'=>'$refresh'];
    public $check_id=[],$type,$transaction_id,$filter_status,$filter_from_bank,$filter_to_bank,$filter_propose,$filter_amount,$filter_note;
    public $payment_date_from,$payment_date_to;
    public function render()
    {
        $data = BankBook::where('type','R')->orderBy('id','desc');
        
        if($this->filter_status!="") $data->where('status',$this->filter_status);
        if($this->filter_from_bank) $data->where('from_bank_id',$this->filter_from_bank);
        if($this->filter_to_bank) $data->where('to_bank_id',$this->filter_to_bank);
        if($this->filter_propose) $data->where('propose',$this->filter_propose);
        if($this->filter_note) $data->where('note','LIKE',"%{$this->filter_note}%");
        if($this->filter_amount) $data->where(function($table){
            $max = (int)(0.1*$this->filter_amount)+$this->filter_amount;
            $min = $this->filter_amount - (int)(0.1*$this->filter_amount);
            $table->where('amount','<=',$max)->where('amount','>=',$min);
        });
        if($this->payment_date_from and $this->payment_date_to) {
            if($this->payment_date_from == $this->payment_date_to)
                $data->whereDate('payment_date',$this->payment_date_from);
            else
                $data->whereBetween('payment_date',[$this->payment_date_from,$this->payment_date_to]);
        }
        
        return view('livewire.bank-book.teknik')->with(['data'=>$data->paginate(100)]);
    }

    public function clear_filter()
    {
        $this->reset(['filter_status','filter_from_bank','filter_to_bank','filter_amount','payment_date_from','payment_date_to']);
        $this->emit('clear-filter');
    }

    public function mount()
    {
        $this->premium_receivable = Income::where('reference_type','Premium Receivable')->get();
    }

    public function updated($propertyName)
    {
        if($propertyName=='type') $this->emit('select-premium-receivable');
        
        $query['filter_status'] = $this->filter_status;
        $query['filter_from_bank'] = $this->filter_from_bank;
        $query['filter_to_bank'] = $this->filter_to_bank;
        $query['filter_propose'] = $this->filter_propose;
        $query['filter_note'] = $this->filter_note;
        $query['filter_amount'] = $this->filter_amount;
        $query['payment_date_from'] = $this->payment_date_from;
        $query['payment_date_to'] = $this->payment_date_to;
        
        $query['page'] = $this->page;

        session(['url_back'=>route('bank-book.teknik',$query)]);

        if($propertyName=='check_id') $this->emit('set_bank_book',$this->check_id);
    }
}