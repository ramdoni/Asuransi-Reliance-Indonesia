<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;

class EndorsementCheckData extends Component
{
    protected $listeners = [
        'emit-check-data-endorsement'=>'$refresh',
        'delete-all-endorsement' => 'deleteAll',
        'keep-all-endorsement' => 'keepAll',
        'replace-all-endorsement' => 'replaceAll',
        'delete-endorsement' => 'delete',
        'replace-endorsement' => 'replace',
        'keep-endorsement' => 'keep'
    ];
    public $keyword,$perpage=100;
    public function render()
    {
        $data = \App\Models\SyariahEndorsement::orderBy('id','DESC')->where('is_temp',1);
        if($this->keyword) $data = $data->where(function($table){
                                                foreach(\Illuminate\Support\Facades\Schema::getColumnListing('syariah_endorsement') as $column){
                                                    $table->orWhere($column,'LIKE',"%{$this->keyword}%");
                                                }
                                            });
        return view('livewire.syariah.underwriting-check-data')->with(['data'=>$data->paginate($this->perpage)]);
    }
    public function replaceAll()
    {
        foreach(\App\Models\SyariahEndorsement::where('is_temp')->get() as $child){
            \App\Models\SyariahEndorsement::find($child->parent_id)->delete();
            $child->is_temp=0;
            $child->parent_id=0;
            $child->save();
        }
        $this->emit('refresh-page');
    }
    public function deleteAll()
    {
        \App\Models\SyariahEndorsement::where('is_temp',1)->delete();
        $this->emit('refresh-page');
    }
    public function keepAll()
    {
        \App\Models\SyariahEndorsement::where('is_temp',1)->update(['is_temp'=>0,'parent_id'=>0]);
    }
    public function delete($id)
    {
        \App\Models\SyariahEndorsement::find($id)->delete();
    }
    public function keep($id)
    {
        \App\Models\SyariahEndorsement::find($id)->update(['is_temp'=>0,'parent_id'=>0]);
    }
    public function replace($id)
    {
        $child = \App\Models\SyariahEndorsement::find($id);
        if($child){
            \App\Models\SyariahEndorsement::find($child->parent_id)->delete();
            $child->is_temp=0;
            $child->parent_id=0;
            $child->save();   
        }
    }
}
