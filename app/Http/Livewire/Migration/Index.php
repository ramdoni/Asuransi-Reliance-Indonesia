<?php

namespace App\Http\Livewire\Migration;

use Livewire\Component;
use App\Models\MigrationData;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $file;

    public function render()
    {
        $data = MigrationData::orderBy('id');

        return view('livewire.migration.index')->with(['data'=>$data->paginate(100)]);
    }

    public function upload(Request $r)
    {
        $this->validate([
            'file'=>'required|mimes:xls,xlsx|max:51200' // 50MB maksimal
        ]);

        $path = $this->file->getRealPath();
       
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $data = $reader->load($path);
        $sheetData = $data->getActiveSheet()->toArray();
        
        if(count($sheetData) > 0){
            $countLimit = 1;
            foreach($sheetData as $key => $i){
                if($key<1) continue; // skip header
                
                foreach($i as $k=>$a){$i[$k] = trim($a);}
                 
                dd($i);
            }
        }
        
        session()->flash('message-success','Upload success !');   
        
        return redirect()->route('migration.index');
    }
}
