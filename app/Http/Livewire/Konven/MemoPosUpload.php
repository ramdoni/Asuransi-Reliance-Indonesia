<?php

namespace App\Http\Livewire\Konven;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
class MemoPosUpload extends Component
{
    use WithFileUploads;
    public $file;
    public function render()
    {
        return view('livewire.konven.memo-pos-upload');
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
            foreach($sheetData as $key => $i){
                if($key<2) continue; // skip header
                
                foreach($i as $k=>$a){$i[$k] = trim($a);}

                $bulan = $i[1];
                $user = $i[2];
                $user_akseptasi = $i[3];
                $berkas_akseptasi = $i[4];
                $tgl_pengajuan_email = $i[5];
                $tgl_produksi = $i[6];
                $no_reg = $i[7];
                $no_reg_sistem = $i[8];
                $no_dn_cn = $i[9];
                $no_dn_cn_sistem = $i[10];
                $jenis_po = $i[11];
                $status = $i[12];
                $posting = $i[13];
                $jenis_po_2 = $i[14];
                $ket_perubahan1 = $i[15];
                $ket_perubahan2 = $i[16];
                $no_polis = $i[17];
                $pemegang_polis = $i[18];
                $cabang = $i[19];
                $produk = $i[20];
                $alamat = $i[21];
                $up_tujuan_surat = $i[22];
                $tujuan_pembayaran = $i[23];
                $bank = $i[24];
                $no_rekening = $i[25];
                $jumlah_peserta_pending = $i[26];
                $up_peserta_pending = $i[27];
                $premi_peserta_pending = $i[28];
                $peserta = $i[29];
                $no_peserta_awal = $i[30];
                $no_peserta_akhir = $i[32];
                $no_sertifikat_awal = $i[33];
                $no_sertifikat_akhir = $i[34];
                $periode_awal = $i[35];
                $periode_akhir = $i[36];
                $tgl_proses = $i[37];
                $movement = $i[38];
                $tgl_invoice = $i[39];
                $tgl_invoice2 = $i[40];
                $no_kwitansi_finance = $i[41];
                $no_kwitansi_finance2 = $i[42];
                $total_gross_kwitansi = $i[43];
                $total_gross_kwitansi2 = $i[44];
                $jumlah_peserta_update = $i[45];
                $up_cancel = $i[46];
                $premi_gross_cancel	 = $i[47];
                $extra_premi = $i[48];
                $extextra = $i[49];
                $rpextra = $i[50];
                $diskon_premi = $i[51];
                $jml_diskon = $i[52];
                $rp_diskon = $i[53];
                $extdiskon = $i[54];
                $fee = $i[55];
                $jml_handling_fee = $i[56];
                $ext_fee = $i[57];
                $rp_fee = $i[58];
                $tampilan_fee = $i[59];
                $pph = $i[60];
                $jml_pph = $i[61];
                $extpph = $i[62];
                $rppph = $i[63];
                $ppn = $i[64];
                $jml_ppn = $i[65];
                $extppn = $i[66];
                $rpppn = $i[67];
                $biaya_sertifikat = $i[68];
                $extbiayasertifikat = $i[69];
                $rpbiayasertifikat = $i[70];
                $extpstsertifikat = $i[71];
                $net_sblm_endors = $i[72];
                $data_stlh_endors = $i[73];
                $up_stlh_endors = $i[74];
                $premi_gross_endors = $i[75];
                $extra_premi2 = $i[76];
                $extem = $i[77];
                $rpxtra = $i[78];
                $discount = $i[79];
                $jml_discount = $i[80];
                $ext_discount = $i[81];
                $rpdiscount = $i[82];
                $handling_fee = $i[83];
                $extfee = $i[84];
                $rpfee = $i[85];
                $tampilanfee = $i[86];
                $pph2 = $i[87];
                $jml_pph2 = $i[88];
                $extpph2 = $i[89];
                $rppph2 = $i[90];
                $ppn2 = $i[91];
                $jml_ppn2 = $i[92];
                $extppn2 = $i[93];
                $rpppn2 = $i[94];
                $biaya_sertifikat2 = $i[95];
                $extbiayasertifikat2 = $i[96];
                $rpbiayasertifikat2 = $i[97];
                $extpstsertifikat2 = $i[98];
                $net_stlh_endors = $i[99];
                $refund = $i[100];
                $terbilang = $i[101];
                $ket_lampiran = $i[102];
                $grace_periode = $i[103];
                $grace_periode_nominal = $i[104];
                $tgl_jatuh_tempo = $i[105];
                $tgl_update_database = $i[106];
                $tgl_update_sistem = $i[107];
                $no_berkas_sistem = $i[108];
                $tgl_posting_sistem = $i[109];
                $no_debit_note_finance = $i[110];
                $tgl_bayar = $i[111];
                $ket = $i[112];
                $tgl_output_email = $i[113];
                $no_berkas2 = $i[114];

                $data = new \App\Models\KonvenMemo();
                $data->bulan = $bulan;
                $data->user = $user;
                $data->user_akseptasi = $user_akseptasi;
                $data->berkas_akseptasi = $berkas_akseptasi;
                if($tgl_pengajuan_email)
                    $data->tgl_pengajuan_email = date('Y-m-d',strtotime($tgl_pengajuan_email));
                
                if($tgl_produksi)
                    $data->tgl_produksi = date('Y-m-d',strtotime($tgl_produksi));

                $data->no_reg = $no_reg;
                $data->no_reg_sistem = $no_reg_sistem;
                $data->no_dn_cn = $no_dn_cn;
                $data->no_dn_cn_sistem = $no_dn_cn_sistem;
                $data->jenis_po = $jenis_po;
                $data->status = $status;
                $data->posting = $posting;
                $data->jenis_po_2 = $jenis_po_2;
                $data->ket_perubahan1 = $ket_perubahan1;
                $data->ket_perubahan2 = $ket_perubahan2;
                $data->no_polis = $no_polis;
                $data->pemegang_polis = $pemegang_polis;
                $data->cabang = $cabang;
                $data->produk = $produk;
                $data->alamat = $alamat;
                $data->up_tujuan_surat = $up_tujuan_surat;
                $data->tujuan_pembayaran = $tujuan_pembayaran;
                $data->bank = $bank;
                $data->no_rekening = $no_rekening;
                $data->jumlah_peserta_pending = $jumlah_peserta_pending;
                $data->up_peserta_pending = $up_peserta_pending;
                $data->premi_peserta_pending = $premi_peserta_pending;
                $data->peserta = $peserta;
                $data->no_peserta_awal = $no_peserta_awal;
                $data->no_peserta_akhir = $no_peserta_akhir;
                $data->no_sertifikat_awal = $no_sertifikat_awal;
                $data->no_sertifikat_akhir = $no_sertifikat_akhir;
                if($periode_awal)
                    $data->periode_awal = date('Y-m-d',strtotime($periode_awal));    
                if($periode_akhir)
                    $data->periode_akhir = date('Y-m-d',strtotime($periode_akhir));
                if($tgl_proses)
                    $data->tgl_proses = date('Y-m-d',strtotime($tgl_proses));
                $data->movement = $movement;
                if($tgl_invoice)
                    $data->tgl_invoice = date('Y-m-d',strtotime($tgl_invoice));
                if($tgl_invoice2)
                    $data->tgl_invoice2 = date('Y-m-d',strtotime($tgl_invoice2));
                
                $data->no_kwitansi_finance = $no_kwitansi_finance;
                $data->no_kwitansi_finance2 = $no_kwitansi_finance2;
                $data->total_gross_kwitansi = $total_gross_kwitansi;
                $data->total_gross_kwitansi2 = $total_gross_kwitansi2;
                $data->jumlah_peserta_update = $jumlah_peserta_update;
                $data->up_cancel = $up_cancel;
                $data->premi_gross_cancel = $premi_gross_cancel;
                $data->extra_premi = $extra_premi;
                $data->extextra = $extextra;
                $data->rpextra = $rpextra;
                $data->diskon_premi = $diskon_premi;
                $data->jml_diskon = $jml_diskon;
                $data->rp_diskon = $rp_diskon;
                $data->extdiskon = $extdiskon;
                $data->fee = $fee;
                $data->jml_handling_fee = $jml_handling_fee;
                $data->ext_fee = $ext_fee;
                $data->rp_fee = $rp_fee;
                $data->tampilan_fee = $tampilan_fee;
                $data->pph = $pph;
                $data->jml_pph = $jml_pph;
                $data->extpph = $extpph;
                $data->rppph = $rppph;
                $data->ppn = $ppn;
                $data->jml_ppn = $jml_ppn;
                $data->extppn = $extppn;
                $data->rpppn = $rpppn;
                $data->biaya_sertifikat = $biaya_sertifikat;
                $data->extbiayasertifikat = $extbiayasertifikat;
                $data->rpbiayasertifikat = $rpbiayasertifikat;
                $data->extpstsertifikat = $extpstsertifikat;
                $data->net_sblm_endors = $net_sblm_endors;
                $data->data_stlh_endors = $data_stlh_endors;
                $data->up_stlh_endors = $up_stlh_endors;
                $data->premi_gross_endors = $premi_gross_endors;
                $data->extra_premi2 = $extra_premi2;
                $data->extem = $extem;
                $data->rpxtra = $rpxtra;
                $data->discount = $discount;
                $data->jml_discount = $jml_discount;
                $data->ext_discount = $ext_discount;
                $data->rpdiscount = $rpdiscount;
                $data->handling_fee = $handling_fee;
                $data->extfee = $extfee;
                $data->rpfee = $rpfee;
                $data->tampilanfee = $tampilanfee;
                $data->pph2 = $pph2;
                $data->jml_pph2 = $jml_pph2;
                $data->extpph2 = $extpph2;
                $data->rppph2 = $rppph2;
                $data->ppn2 = $ppn2;
                $data->jml_ppn2 = $jml_ppn2;
                $data->extppn2 = $extppn2;
                $data->rpppn2 = $rpppn2;
                $data->biaya_sertifikat2 = $biaya_sertifikat2;
                $data->extbiayasertifikat2 = $extbiayasertifikat2;
                $data->rpbiayasertifikat2 = $rpbiayasertifikat2;
                $data->extpstsertifikat2 = $extpstsertifikat2;
                $data->net_stlh_endors = $net_stlh_endors;
                $data->refund = $refund;
                $data->terbilang = $terbilang;
                $data->ket_lampiran = $ket_lampiran;
                $data->grace_periode = $grace_periode;
                $data->grace_periode_nominal = $grace_periode_nominal;
                if($tgl_jatuh_tempo)
                    $data->tgl_jatuh_tempo = date('Y-m-d',strtotime($tgl_jatuh_tempo));
                if($tgl_update_database)
                    $data->tgl_update_database = date('Y-m-d',strtotime($tgl_update_database));
                if($tgl_update_sistem)
                    $data->tgl_update_sistem = date('Y-m-d',strtotime($tgl_update_sistem));
                $data->no_berkas_sistem = $no_berkas_sistem;
                $data->tgl_posting_sistem = $tgl_posting_sistem;
                $data->no_debit_note_finance = $no_debit_note_finance;
                if($tgl_bayar)
                    $data->tgl_bayar = date('Y-m-d',strtotime($tgl_bayar));
                $data->ket = $ket;
                if($tgl_output_email)
                    $data->tgl_output_email = date('Y-m-d',strtotime($tgl_output_email));
                $data->no_berkas2 = $no_berkas2;
                $data->save();
            }
        }
        session()->flash('message-success','Upload success !');   
        return redirect()->route('konven.underwriting');
    }
}
