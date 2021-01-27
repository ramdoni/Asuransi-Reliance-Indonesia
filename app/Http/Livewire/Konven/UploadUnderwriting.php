<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

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
        $this->validate([
            'file'=>'required|mimes:xls,xlsx|max:51200' // 50MB maksimal
        ]);
        
        $path = $this->file->getRealPath();
       
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $data = $reader->load($path);
        $sheetData = $data->getActiveSheet()->toArray();
        
        if(count($sheetData) > 0){
            $countLimit = 1;
            $total_double = 0;
            $total_success = 0;
            \App\Models\KonvenUnderwriting::where('is_temp',1)->delete(); // delete data temp
            foreach($sheetData as $key => $i){
                if($key<1) continue; // skip header
                
                foreach($i as $k=>$a){ $i[$k] = trim($a); }
                
                $bulan = $i[1];
                $user_memo = $i[2];
                $user_akseptasi = $i[3];
                $transaksi_id = $i[4];
                $berkas_akseptasi = $i[5];
                $tanggal_pengajuan_email = $i[6]? @\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[6]):'';
                $tanggal_produksi = $i[7]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[7]):'';;
                $no_reg = $i[8];
                $no_polis = $i[9];
                $no_polis_sistem = $i[10];
                $pemegang_polis = $i[11];
                $alamat = $i[12];
                $cabang = $i[13];
                $produk = $i[14];
                $jumlah_peserta_pending = replace_idr($i[15]);
                $up_peserta_pending = replace_idr($i[16]);
                $premi_peserta_pending = replace_idr($i[17]);
                $jumlah_peserta = replace_idr($i[18]);
                $nomor_peserta_awal = $i[19];
                $extsd = $i[20];
                $nomor_peserta_akhir = $i[21];
                $periode_awal = $i[22]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[22]):'';
                $periode_akhir = $i[23]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[23]):'';
                $up = replace_idr($i[24]);
                $premi_gross = replace_idr($i[25]);
                $extra_premi = replace_idr($i[26]);
                $discount = replace_idr($i[27]);
                $jumlah_discount = replace_idr($i[28]);
                $jumlah_cad_klaim = replace_idr($i[29]);
                $ext_diskon = $i[30];
                $cad_klaim = $i[31];
                $handling_fee = replace_idr($i[32]);
                $jumlah_fee = replace_idr($i[33]);
                $pph = replace_idr($i[34]);
                $jumlah_pph = replace_idr($i[35]);
                $ppn = replace_idr($i[36]);
                $jumlah_ppn = replace_idr($i[37]);
                $biaya_polis = replace_idr($i[38]);
                $biaya_sertifikat = replace_idr($i[39]);
                $extsertifikat = replace_idr($i[40]);
                $premi_netto = replace_idr($i[41]);
                $terbilang = $i[42];
                $tgl_update_database = $i[43]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[43]):'';
                $tgl_update_sistem = $i[44]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[44]):'';
                $no_berkas_sistem = $i[45];
                $tgl_posting_sistem = $i[46]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[46]):'';
                $ket_postingan = $i[47];
                $tgl_invoice = $i[48]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[48]):'';
                $no_kwitansi_debit_note = $i[49];
                $total_gross_kwitansi = replace_idr($i[50]);
                $grace_periode_terbilang = $i[51];
                $grace_periode = $i[52];
                $tgl_jatuh_tempo = $i[53]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[53]):'';
                $extend_tgl_jatuh_tempo = $i[54]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[54]):'';
                $tgl_lunas = $i[55]?@\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($i[5]):'';
                $ket_lampiran = $i[56];
                $line_bussines = $i[68];
                if(empty($no_polis))continue; // skip data
                // cek no polis
                $polis = \App\Models\Policy::where('no_polis',$no_polis)->first();
                if(!$polis){
                    $polis = new \App\Models\Policy();
                    $polis->no_polis = $no_polis;
                    $polis->no_polis_sistem = $no_polis_sistem;
                    $polis->pemegang_polis = $pemegang_polis;
                    $polis->alamat = $alamat;
                    $polis->cabang = $cabang;
                    $polis->produk = $produk;
                    $polis->save();
                }

                $total_success++;

                $check = \App\Models\KonvenUnderwriting::where('no_kwitansi_debit_note',$no_kwitansi_debit_note)->first();
                if(!$check)
                    $data = new \App\Models\KonvenUnderwriting();
                else{
                    $income = \App\Models\Income::where(['transaction_table'=>'konven_underwriting','transaction_id'=>$check->id])->first();
                    if(isset($income) and $income->status==2) continue; // skip jika data sudah di receive
                    
                    $data = new \App\Models\KonvenUnderwriting();
                    $data->is_temp = 1;
                    $data->parent_id = $check->id;
                    $total_double++;
                }

                $data->user_id = \Auth::user()->id;
                $data->bulan = $bulan;
                $data->no_reg = $no_reg;
                $data->user_memo = $user_memo;
                $data->user_akseptasi = $user_akseptasi;
                $data->transaksi_id = $transaksi_id;
                $data->berkas_akseptasi = $berkas_akseptasi;
                if($tanggal_pengajuan_email) $data->tanggal_pengajuan_email = date('Y-m-d',$tanggal_pengajuan_email);
                if($tanggal_produksi) $data->tanggal_produksi = date('Y-m-d',$tanggal_produksi);
                $data->no_reg = $no_reg;
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