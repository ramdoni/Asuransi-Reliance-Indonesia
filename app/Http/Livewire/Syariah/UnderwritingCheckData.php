<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;

class UnderwritingCheckData extends Component
{
    protected $listeners = [
        'emit-check-data-underwriting'=>'$refresh',
        'delete-all-underwriting' => 'deleteAll',
        'keep-all-underwriting' => 'keepAll',
        'replace-all-underwriting' => 'replaceAll',
        'delete-underwriting' => 'delete',
        'replace-underwriting' => 'replace',
        'keep-underwriting' => 'keep'
    ];
    public $keyword,$perpage=100;
    public function render()
    {
        $data = \App\Models\SyariahUnderwriting::orderBy('id','DESC')->where('is_temp',1);
        if($this->keyword) $data = $data->where(function($table){
                                                foreach(\Illuminate\Support\Facades\Schema::getColumnListing('syariah_underwriting') as $column){
                                                    $table->orWhere($column,'LIKE',"%{$this->keyword}%");
                                                }
                                            });
        return view('livewire.syariah.underwriting-check-data')->with(['data'=>$data->paginate($this->perpage)]);
    }
    public function replaceAll()
    {
        foreach(\App\Models\SyariahUnderwriting::where('is_temp')->get() as $child){
            \App\Models\SyariahUnderwriting::find($child->parent_id)->delete();
            $child->is_temp=0;
            $child->parent_id=0;
            $child->save();
        }
        $this->emit('refresh-page');
    }
    public function deleteAll()
    {
        \App\Models\SyariahUnderwriting::where('is_temp',1)->delete();
        $this->emit('refresh-page');
    }
    public function keepAll()
    {
        \App\Models\SyariahUnderwriting::where('is_temp',1)->update(['is_temp'=>0,'parent_id'=>0]);
    }
    public function delete($id)
    {
        \App\Models\SyariahUnderwriting::find($id)->delete();
    }
    public function keep($id)
    {
        \App\Models\SyariahUnderwriting::find($id)->update(['is_temp'=>0,'parent_id'=>0]);
    }
    public function replace($id)
    {
        $child = \App\Models\SyariahUnderwriting::find($id);
        if($child){
            \App\Models\SyariahUnderwriting::find($child->parent_id)->delete();
            $child->is_temp=0;
            $child->parent_id=0;
            $child->save();   
        }
    }
}
