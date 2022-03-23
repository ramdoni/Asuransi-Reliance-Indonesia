<?php

namespace App\Http\Livewire\DistributionChannel;

use Livewire\Component;
use App\Models\DistributionChannel;

class Index extends Component
{
    public $name,$description,$is_insert=false;
    public function render()
    {
        $data = DistributionChannel::orderBy('id','DESC');

        return view('livewire.distribution-channel.index')->with(['data'=>$data->paginate(100)]);
    }

    public function save()
    {
        $data = new DistributionChannel();
        $data->name = $this->name;
        $data->description = $this->description;
        $data->save();

        $this->is_insert = false;
        $this->emit('message-success','Data saved');
    }
}
