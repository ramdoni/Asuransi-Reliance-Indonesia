<?php

namespace App\Http\Livewire\Syariah;

use Livewire\Component;
use Livewire\WithFileUploads;

class EndorsementUpload extends Component
{
    use WithFileUploads;
    public $file;
    public function render()
    {
        return view('livewire.syariah.endorsement-upload');
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
            \App\Models\SyariahEndorsement::where('is_temp',1)->delete(); // delete data temp
            foreach($sheetData as $key => $i){
                if($key<1) continue; // skip header
                foreach($i as $k=>$a){ $i[$k] = trim($a); }
                $bulan = $i[1];
                $user_memo = $i[2];
                $user_akseptasi = $i[3];
                $berkas_akseptasi = $i[4];
                $tgl_pengajuan_email = $i[5];
                $tgl_endors = $i[6];
                $no_memo = $i[7];
                $no_dn_cn = $i[8];
                $jenis_perubahan = $i[9];
                $no_polis = $i[10];
                $pemegang_polis = $i[11];
                $cabang = $i[12];
                $nama_produk = $i[13];
                $alamat = $i[14];
                $tujuan_pembayaran = $i[15];
                $bank = $i[16];
                $no_rekening = $i[17];
                $grace_periode = $i[18];
                $jumlah_kepesertaan = $i[19];
                $no_kepesertaan_awal = $i[20];
                $no_kepesertaan_akhir = $i[22];
                $jumlah_kepesertaan_sebelum_endors = $i[23];
                $manfaat_sebelum_endors = $i[24];
                $dana_tab_baru_sebelum_endors = $i[25];
                $dana_ujrah_sebelum_endors = $i[26];
                $kontribusi_cancel = $i[27];
                $extra_kontribusi = (int)$i[28];
                $discount = (int)$i[29];
                $jumlah_discount = (int)$i[30];
                $handling_fee = (int)$i[31];
                $jumlah_fee = (int)$i[32];
                $pph = (int)$i[33];
                $jumlah_pph = (int)$i[34];
                $ppn = (int)$i[35];
                $jumlah_ppn = $i[36];
                $biaya_polis = (int)$i[37];
                $biaya_sertifikat = (int)$i[38];
                $ext_biaya_sertifikat = $i[39];
                $rp_biaya_sertifikat = (int)$i[40];
                $ext_pst_sertifikat = $i[41];
                $net_sebelum_endors = (int)$i[42];
                $Jumlah_kepesertaan_setelah_endors = (int)$i[43];
                $manfaat_setelah_endors = (int)$i[44];
                $dana_tab_baru_setelah_endors = (int)$i[45];
                $dana_ujrah_setelah_endors = (int)$i[46];
                $kontribusi_endors = $i[47];
                $extra_kontribusi_2 = $i[48];
                $discount_2 = $i[49];
                $jumlah_discount_2 = $i[50];
                $handling_fee_2 = $i[51];
                $jumlah_fee_2 = $i[52];
                $pph_2 = $i[53];
                $jumlah_pph_2 = $i[54];
                $ppn_2 = $i[55];
                $jumlah_ppn_2 = $i[56];
                $biaya_polis_2 = (int)$i[57];
                $biaya_sertifikat_2 = (int)$i[58];
                $net_setelah_endors = $i[59];
                $dengan_tagihan_atau_refund_premi = $i[60];
                $terbilang = $i[61];
                $grace_periode_2 = $i[62];
                $tgl_jatoh_tempo = $i[63];
                $tgl_update_database = $i[64];
                $tgl_bayar = $i[65];
                $find = \App\Models\SyariahEndorsement::where('no_dn_cn',$no_dn_cn)->first();
                $data = new \App\Models\SyariahEndorsement();
                if($find){
                    $data->is_temp = 1;
                    $data->parent_id = $find->id;
                    $total_double++;
                }else $data->is_temp = 0;
                $data->bulan = $bulan;
                $data->user_memo = $user_memo;
                $data->berkas_akseptasi = $berkas_akseptasi;
                if($tgl_pengajuan_email) $data->tgl_pengajuan_email = date('Y-m-d',strtotime($tgl_pengajuan_email));
                if($tgl_endors)$data->tgl_endors = date('Y-m-d',strtotime($tgl_endors));
                $data->no_memo = $no_memo;
                $data->no_dn_cn = $no_dn_cn;
                $data->jenis_perubahan = $jenis_perubahan;
                $data->no_polis = $no_polis;
                $data->pemegang_polis = $pemegang_polis;
                $data->cabang = $cabang;
                $data->nama_produk = $nama_produk;
                $data->alamat = $alamat;
                $data->tujuan_pembayaran = $tujuan_pembayaran;
                $data->bank = $bank;
                $data->no_rekening = $no_rekening;
                $data->grace_periode = $grace_periode;
                $data->jumlah_kepesertaan = $jumlah_kepesertaan;
                $data->no_kepesertaan_awal = $no_kepesertaan_awal;
                $data->no_kepesertaan_akhir = $no_kepesertaan_akhir;
                $data->jumlah_kepesertaan_sebelum_endors = $jumlah_kepesertaan_sebelum_endors;
                $data->manfaat_sebelum_endors = $manfaat_sebelum_endors;
                $data->dana_tab_baru_sebelum_endors = $dana_tab_baru_sebelum_endors;
                $data->dana_ujrah_sebelum_endors = $dana_ujrah_sebelum_endors;
                $data->kontribusi_cancel = $kontribusi_cancel;
                $data->extra_kontribusi = $extra_kontribusi;
                $data->discount = $discount;
                $data->jumlah_discount = $jumlah_discount;
                $data->handling_fee = $handling_fee;
                $data->jumlah_fee = $jumlah_fee;
                $data->pph = $pph;
                $data->jumlah_pph = $jumlah_pph;
                $data->ppn = $ppn;
                $data->jumlah_ppn = $jumlah_ppn;
                $data->biaya_polis = $biaya_polis;
                $data->biaya_sertifikat = $biaya_sertifikat;
                $data->ext_biaya_sertifikat = $ext_biaya_sertifikat;
                $data->rp_biaya_sertifikat = $rp_biaya_sertifikat;
                $data->ext_pst_sertifikat = $ext_pst_sertifikat;
                $data->net_sebelum_endors = $net_sebelum_endors;
                $data->Jumlah_kepesertaan_setelah_endors = $Jumlah_kepesertaan_setelah_endors;
                $data->manfaat_setelah_endors = $manfaat_setelah_endors;
                $data->dana_tab_baru_setelah_endors = $dana_tab_baru_setelah_endors;
                $data->dana_ujrah_setelah_endors = $dana_ujrah_setelah_endors;
                $data->kontribusi_endors = $kontribusi_endors;
                $data->extra_kontribusi_2 = $extra_kontribusi_2;
                $data->discount_2	 = $discount_2	;
                $data->jumlah_discount_2 = $jumlah_discount_2;
                $data->handling_fee_2 = $handling_fee_2;
                $data->jumlah_fee_2 = $jumlah_fee_2;
                $data->pph_2 = $pph_2;
                $data->jumlah_pph_2 = $jumlah_pph_2;
                $data->ppn_2 = $ppn_2;
                $data->jumlah_ppn_2 = $jumlah_ppn_2;
                $data->biaya_polis_2 = $biaya_polis_2;
                $data->biaya_sertifikat_2 = $biaya_sertifikat_2;
                $data->net_setelah_endors = $net_setelah_endors;
                $data->dengan_tagihan_atau_refund_premi = $dengan_tagihan_atau_refund_premi;
                $data->terbilang = $terbilang;
                $data->grace_periode_2 = $grace_periode_2;
                if($tgl_jatoh_tempo) $data->tgl_jatoh_tempo = date('Y-m-d',strtotime($tgl_jatoh_tempo));
                if($tgl_update_database) $data->tgl_update_database = date('Y-m-d',strtotime($tgl_update_database));
                if($tgl_bayar) $data->tgl_bayar = date('Y-m-d',strtotime($tgl_bayar));
                $data->status = 1;
                $data->user_id = \Auth::user()->id;
                $data->save();
                $total_success++;
            }
        }
        if($total_double>0)
            $this->emit('emit-check-data-endorsement');
        else{
            session()->flash('message-success','Upload success, Success Upload <strong>'. $total_success.'</strong>, Double Data :<strong>'. $total_double.'</strong>');   
            $this->emit('refresh-page');
        }
    }
}
