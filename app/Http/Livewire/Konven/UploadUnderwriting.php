<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\KonvenUnderwriting;
use App\Models\Policy;
use App\Models\Income;

class UploadUnderwriting extends Component
{
    use WithFileUploads;

    public $file;
    public function render()
    {
        return view('livewire.konven.upload-underwriting');
    }

    public function save()
    {
        ini_set('memory_limit', '10024M'); // or you could use 1G
        $this->validate([
            'file'=>'required|mimes:xls,xlsx|max:51200' // 50MB maksimal
        ]);
        
        $path = $this->file->getRealPath();
       
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $data = $reader->load($path);
        $sheetData = $data->getActiveSheet()->toArray();
        $total_double = 0;
        $countLimit = 1;
        $total_success = 0;
        if(count($sheetData) > 0){
            
            KonvenUnderwriting::where('is_temp',1)->delete(); // delete data temp
            foreach($sheetData as $key => $i){
                if($key<1) continue; // skip header
                
                foreach($i as $k=>$a){ $i[$k] = trim($a); }
                
                $no_polis = $i[0];
                $pemegang_polis = $i[1];
                $alamat = $i[2];
                $cabang = $i[3];
                $premi_gross = round($i[4]);
                $extra_premi = round($i[5]);
                $discount = round($i[6]);
                $jumlah_discount = round($i[7]);
                $handling_fee = round($i[8]);
                $jumlah_fee = round($i[9]);
                $jumlah_pph = round($i[10]);
                $jumlah_ppn = round($i[11]);
                $biaya_polis = round($i[12]);
                $biaya_sertifikat = round($i[13]);
                $extsertifikat = round($i[14]);
                $premi_netto = round($i[15]);
                $tgl_invoice = $i[16]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[16]):'';
                $no_kwitansi_debit_note = $i[17];
                $total_gross_kwitansi = round($i[18]);
                $tgl_jatuh_tempo = $i[19]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[19]):'';
                $tgl_lunas = $i[20]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[20]):'';
                $line_bussines = $i[21];
                $channel_type = $i[22];
                $channel_name = $i[23];
                if(empty($no_polis))continue; // skip data
                // cek no polis
                $polis = Policy::where('no_polis',$no_polis)->first();
                if(!$polis){
                    $polis = new Policy();
                    $polis->no_polis = $no_polis;
                    $polis->pemegang_polis = $pemegang_polis;
                    $polis->alamat = $alamat;
                    $polis->cabang = $cabang;
                    $polis->type = 1; // konven
                    $polis->save();
                }

                $total_success++;

                $check = KonvenUnderwriting::where('no_kwitansi_debit_note',$no_kwitansi_debit_note)->first();
                if(!$check)
                    $data = new KonvenUnderwriting();
                else{
                    $income = Income::where(['transaction_table'=>'konven_underwriting','transaction_id'=>$check->id])->first();
                    if(isset($income) and $income->status==2) continue; // skip jika data sudah di receive
                    
                    $data = new KonvenUnderwriting();
                    $data->is_temp = 1;
                    $data->parent_id = $check->id;
                    $total_double++;
                }

                $data->user_id = \Auth::user()->id;
                $data->no_polis = $no_polis;
                $data->pemegang_polis = $pemegang_polis;
                $data->alamat = $alamat;
                $data->cabang = $cabang;
                $data->premi_gross = $premi_gross;
                $data->extra_premi = $extra_premi;
                $data->discount = $discount;
                $data->jumlah_discount = $jumlah_discount;
                $data->handling_fee = $handling_fee;
                $data->jumlah_fee = $jumlah_fee;
                $data->jumlah_pph = $jumlah_pph;
                $data->jumlah_ppn = $jumlah_ppn;
                $data->biaya_sertifikat = $biaya_sertifikat;
                $data->extsertifikat = $extsertifikat;
                $data->biaya_polis = $biaya_polis;
                $data->premi_netto = $premi_netto;
                if($tgl_invoice) $data->tgl_invoice = date('Y-m-d',$tgl_invoice);
                $data->no_kwitansi_debit_note = $no_kwitansi_debit_note;
                $data->total_gross_kwitansi = $total_gross_kwitansi;
                if($tgl_jatuh_tempo) $data->tgl_jatuh_tempo = date('Y-m-d',$tgl_jatuh_tempo);
                if($tgl_lunas) $data->tgl_lunas = date('Y-m-d',$tgl_lunas);
                $data->status = 1;
                $data->line_bussines = $line_bussines;
                $data->channel_type = $channel_type;
                $data->channel_name = $channel_name;
                $data->save(); 
            }
        }

        if($total_double>0)
            $this->emit('emit-check-data');
        else{
            session()->flash('message-success','Upload success, Success Upload <strong>'. $total_success.'</strong>, Double Data :<strong>'. $total_double.'</strong>');   
            return redirect()->route('konven.underwriting');
        }
    }
}