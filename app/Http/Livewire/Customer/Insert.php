<?php

namespace App\Http\Livewire\Customer;

use Livewire\Component;
use App\Models\Customer;

class Insert extends Component
{
    public $name;
    public $email;
    public $password;
    public $phone;
    public $address;
    public $user_access_id;
    public $message;
   
    public function render()
    {
        return view('livewire.customer.insert');
    }
    
    public function save(){
        $this->validate();
        
        $data = new Customer();
        $data->name = $this->name;
        $data->email = $this->email;
        $data->phone = $this->phone;
        $data->address = $this->address;
        $data->save();

        return redirect()->to('customer');
    }
}
