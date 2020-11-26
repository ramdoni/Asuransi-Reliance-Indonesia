<?php

namespace App\Http\Livewire\CodeCashflow;

use Livewire\Component;

class Insert extends Component
{
    public $group,$code,$name;
    public function render()
    {
        return view('livewire.code-cashflow.insert');
    }

    public function save()
    {
        $this->validate([
            'group'=>'required',
            'name'=>'required',
            'group'=>'required'
        ]);

        $data = new \App\Models\CodeCashflow();
        $data->group = $this->group;
        $data->code = $this->code;
        $data->name = $this->name;
        $data->save();
        
        session()->flash('message-success',__('Data saved successfully'));

        return redirect()->to('code-cashflow');
    }
}
