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
                
                $no_polis = $i[1];
                $pemegang_polis = $i[2];
                $alamat = $i[3];
                $cabang = $i[4];
                $premi_gross = round($i[5]);
                $extra_premi = round($i[6]);
                $discount = round($i[7]);
                $jumlah_discount = round($i[8]);
                $handling_fee = round($i[9]);
                $jumlah_fee = round($i[10]);
                $jumlah_pph = round($i[11]);
                $jumlah_ppn = round($i[12]);
                $biaya_polis = round($i[13]);
                $biaya_sertifikat = round($i[14]);
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
                    $polis->no_polis_sistem = $no_polis_sistem;
                    $polis->pemegang_polis = $pemegang_polis;
                    $polis->alamat = $alamat;
                    $polis->cabang = $cabang;
                    $polis->produk = $produk;
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
                $data->no_polis_sistem = $no_polis_sistem;
                $data->pemegang_polis = $pemegang_polis;
                $data->alamat = $alamat;
                $data->cabang = $cabang;
                $data->produk = $produk;
                $data->jumlah_peserta_pending = $jumlah_peserta_pending;
                $data->up_peserta_pending = $up_peserta_pending;
                $data->premi_peserta_pending = $premi_peserta_pending;
                $data->jumlah_peserta = $jumlah_peserta;
                $data->nomor_peserta_awal = $nomor_peserta_awal;
                $data->nomor_peserta_akhir = $nomor_peserta_akhir;
                if($periode_awal) $data->periode_awal = date('Y-m-d',$periode_awal);
                if($periode_akhir) $data->periode_akhir = date('Y-m-d',$periode_akhir);
                $data->up = $up;
                $data->premi_gross = $premi_gross;
                $data->extra_premi = $extra_premi;
                $data->discount = $discount;
                $data->jumlah_discount = $jumlah_discount;
                $data->jumlah_cad_klaim = $jumlah_cad_klaim;
                $data->ext_diskon = $ext_diskon;
                $data->cad_klaim = $cad_klaim;
                $data->handling_fee = $handling_fee;
                $data->jumlah_fee = $jumlah_fee;
                $data->pph = $pph;
                $data->jumlah_pph = $jumlah_pph;
                $data->ppn = $ppn;
                $data->jumlah_ppn = $jumlah_ppn;
                $data->biaya_polis = $biaya_polis;
                $data->extsertifikat = $extsertifikat;
                $data->premi_netto = $premi_netto;
                $data->terbilang = $terbilang;
                if($tgl_update_database) $data->tgl_update_database = date('Y-m-d',$tgl_update_database);
                if($tgl_update_sistem) $data->tgl_update_sistem = date('Y-m-d',$tgl_update_sistem);
                $data->no_berkas_sistem = $no_berkas_sistem;
                if($tgl_posting_sistem) $data->tgl_posting_sistem = date('Y-m-d',$tgl_posting_sistem);
                $data->ket_postingan = $ket_postingan;
                if($tgl_invoice) $data->tgl_invoice = date('Y-m-d',$tgl_invoice);
                $data->no_kwitansi_debit_note = $no_kwitansi_debit_note;
                $data->total_gross_kwitansi = $total_gross_kwitansi;
                $data->grace_periode_terbilang = $grace_periode_terbilang;
                $data->grace_periode = $grace_periode;
                if($tgl_jatuh_tempo) $data->tgl_jatuh_tempo = date('Y-m-d',$tgl_jatuh_tempo);
                if($extend_tgl_jatuh_tempo) $data->extend_tgl_jatuh_tempo = date('Y-m-d',$extend_tgl_jatuh_tempo);
                if($tgl_lunas) $data->tgl_lunas = date('Y-m-d',$tgl_lunas);
                $data->ket_lampiran = $ket_lampiran;
                $data->status = 1;
                $data->line_bussines = $line_bussines;
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