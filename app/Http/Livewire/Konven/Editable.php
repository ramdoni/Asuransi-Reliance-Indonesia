<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;

class Editable extends Component
{
    public $data,$field,$value;
    public function render()
    {
        return view('livewire.konven.editable');
    }

    public function mount($data,$field)
    {
        $this->data = $data;
        $this->field = $field;
        $this->value = $this->data->$field;
    }

    public function save()
    {
        $field = $this->field;
        $this->data->$field = $this->value;
        $this->data->save();
    }
}