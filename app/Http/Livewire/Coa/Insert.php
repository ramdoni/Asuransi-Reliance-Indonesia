<?php

namespace App\Http\Livewire\Coa;

use Livewire\Component;

class Insert extends Component
{
    public $coa_group_id,$code,$name,$coa_type_id,$description,$code_voucher;
    public function render()
    {
        return view('livewire.coa.insert');
    }

    public function save()
    {
        $this->validate([
            'coa_group_id'=>'required',
            'code'=>'required',
            'name'=>'required',
            'coa_type_id'=>'required'
        ]);
        
        $data = new \App\Models\Coa();
        $data->coa_group_id = $this->coa_group_id;
        $data->code = $this->code;
        $data->name = $this->name;
        $data->coa_type_id = $this->coa_type_id;
        $data->description = $this->description;
        $data->code_voucher = $this->code_voucher;
        $data->save();
        
        session()->flash('message-success',__('Data saved successfully'));

        return redirect()->to('coa');
    }
}
