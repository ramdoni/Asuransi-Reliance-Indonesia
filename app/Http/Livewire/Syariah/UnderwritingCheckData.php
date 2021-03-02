<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;
use Livewire\WithPagination;

class UnderwritingCheckData extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
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
                                                foreach(\Illuminate\Support\Facades\Schema::getColumnListing('syariah_underwritings') as $column){
                                                    $table->orWhere($column,'LIKE',"%{$this->keyword}%");
                                                }
                                            });
        return view('livewire.syariah.underwriting-check-data')->with(['data'=>$data->paginate($this->perpage)]);
    }
    public function updated()
    {
        if(\App\Models\SyariahUnderwriting::where('is_temp',1)->count()==0){
            session()->flash('message-success',__('Data saved successfully'));
            return redirect()->route('syariah.underwriting');
        }
    }
    public function replaceAll()
    {
        foreach(\App\Models\SyariahUnderwriting::where('is_temp',1)->get() as $child){
            $income = \App\Models\Income::where(['transaction_table'=>'syariah_underwriting','transaction_id'=>$child->parent_id])->first();
            if($income) $income->delete();
            \App\Models\SyariahUnderwriting::find($child->parent_id)->delete();
            $child->is_temp=0;
            $child->parent_id=0;
            $child->save();
        }
        $this->updated();
    }
    public function deleteAll()
    {
        \App\Models\SyariahUnderwriting::where('is_temp',1)->delete();
        $this->updated();
    }
    public function keepAll()
    {
        \App\Models\SyariahUnderwriting::where('is_temp',1)->update(['is_temp'=>0,'parent_id'=>0]);
        $this->updated();
    }
    public function delete($id)
    {
        \App\Models\SyariahUnderwriting::find($id)->delete();
        $this->updated();
    }
    public function keep($id)
    {
        \App\Models\SyariahUnderwriting::find($id)->update(['is_temp'=>0,'parent_id'=>0]);
        $this->updated();
    }
    public function replace($id)
    {
        $child = \App\Models\SyariahUnderwriting::find($id);
        if($child){
            $income = \App\Models\Income::where(['transaction_table'=>'syariah_underwriting','transaction_id'=>$child->parent_id])->first();
            if($income) $income->delete();
            \App\Models\SyariahUnderwriting::find($child->parent_id)->delete();
            $child->is_temp=0;
            $child->parent_id=0;
            $child->save();   
        }
        $this->updated();
    }
}
