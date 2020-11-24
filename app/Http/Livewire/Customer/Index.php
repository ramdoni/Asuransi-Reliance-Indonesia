<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;

class Index extends Component
{
    public $keyword;
    
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $data = Customer::orderBy('id','desc');
        
        if($this->keyword) $data = $data->where('name','LIKE','%'.$this->keyword."%")->orWhere('phone','LIKE',"%".$this->keyword."%");
        
        return view('livewire.customer.index')->with(['data'=>$data->paginate(100)]);
    }
}
