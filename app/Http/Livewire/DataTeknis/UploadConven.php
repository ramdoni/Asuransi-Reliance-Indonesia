<?php

namespace App\Http\Livewire\DataTeknis;

use Livewire\Component;
use Livewire\WithFileUploads;

class UploadConven extends Component
{
    use WithFileUploads;

    public $file;
    public function render()
    {
        return view('livewire.data-teknis.upload-conven');
    }

    public function save()
    {
        $this->validate([
            'file'=>'required|mimes:xls,xlsx|max:51200' // 50MB maksimal
        ]);
        
        $this->emit('listenUploaded');
        
        $path = $this->file->getRealPath();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $data = $reader->load($path);
        $sheetData = $data->getActiveSheet()->toArray();
        
        if(count($sheetData) > 0){
            $countLimit = 1;
            foreach($sheetData as $key => $i){
                if($key<3) continue; // skip header
                
                foreach($i as $k=>$a){ $i[$k] = trim($a); }
                
                $bulan = $i[1];
                $user_memo = $i[2];
                $user_akseptasi = $i[3];
                $transaksi_id = $i[4];
                $berkas_akseptasi = $i[5];
                $tanggal_pengajuan_email = date('Y-m-d',strtotime($i[6]));
                $tanggal_produksi = date('Y-m-d',strtotime($i[7]));
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
                $jml_peserta = replace_idr($i[18]);
                $no_peserta_awal = $i[19];
                $extsd = $i[20];
                $no_peserta_akhir = $i[21];
                $periode_awal = date('Y-m-d',strtotime($i[22]));
                $periode_akhir = date('Y-m-d',strtotime($i[23]));
                $up = replace_idr($i[24]);
                $premi_gross = replace_idr($i[25]);
                $extra_premi = replace_idr($i[26]);
                $discount = replace_idr($i[27]);
                $jml_discount = replace_idr($i[28]);
                $jml_cad_klaim = replace_idr($i[29]);
                $extdiskon = $i[30];
                $cad_claim = $i[31];
                $handling_fee = replace_idr($i[32]);
                $jml_fee = replace_idr($i[33]);
                $pph = replace_idr($i[34]);
                $jumlah_pph = replace_idr($i[35]);
                $ppn = replace_idr($i[36]);
                $jumlah_ppn = replace_idr($i[37]);
                $biaya_polis = replace_idr($i[38]);
                $biaya_sertifikat = replace_idr($i[39]);
                $extsertifikat = replace_idr($i[40]);
                $premi_netto = replace_idr($i[41]);
                $terbilang = $i[42];
                $tgl_update_database = date('Y-m-d',strtotime($i[43]));
                $tgl_update_sistem = date('Y-m-d',strtotime($i[44]));
                $no_berkas_sistem = $i[45];
                $tgl_posting_sistem = date('Y-m-d',strtotime($i[46]));
                $ket_postingan = $i[47];
                $tgl_invoice = date('Y-m-d',strtotime($i[48]));
                $no_kwitansi_finance = $i[49];
                $total_gross_kwitansi = $i[50];
                $grace_periode = $i[51];
                $grace_periode_nominal = $i[52];
                $tgl_jatuh_tempo = date('Y-m-d',strtotime($i[53]));
                $extend_tgl_jatuh_tempo = date('Y-m-d',strtotime($i[54]));
                $tgl_lunas = date('Y-m-d',strtotime($i[55]));
                $ket_lampiran = $i[56];
                
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

                $data = new \App\Models\Teknis();
                $data->user_id = \Auth::user()->id;
                $data->bulan = $bulan;
                $data->no_debit_note = $no_reg;
                $data->user_memo = $user_memo;
                $data->user_akseptasi = $user_akseptasi;
                $data->transaksi_id = $transaksi_id;
                $data->berkas_akseptasi = $berkas_akseptasi;
                $data->tanggal_pengajuan_email = $tanggal_pengajuan_email;
                $data->tanggal_produksi = $tanggal_produksi;
                $data->no_reg = $no_reg;
                $data->no_polis = $no_polis;
                $data->no_polis_sistem = $no_polis_sistem;
                $data->pemegang_polis = $pemegang_polis;
                $data->alamat = $alamat;
                $data->cabang = $cabang;
                $data->jenis_produk = $produk;
                $data->jml_kepesertaan_tertunda = $jumlah_peserta_pending;
                $data->manfaat_kepesertaan_tertunda = $up_peserta_pending;
                $data->kontribusi_kepesertaan_tertunda = $premi_peserta_pending;
                $data->jml_kepesertaan = $jml_peserta;
                $data->no_kepesertaan_awal = $no_peserta_awal;
                $data->no_kepesertaan_akhir = $no_peserta_akhir;
                $data->masa_awal_asuransi = $periode_awal;
                $data->masa_akhir_asuransi = $periode_akhir;
                $data->kontribusi = $up;
                $data->premi_gross = $premi_gross;
                $data->ektra_kontribusi = $extra_premi;
                $data->discount = $discount;
                $data->jumlah_diskon =$jml_discount;
                $data->handling_fee = $handling_fee;
                $data->jumlah_fee = $jml_fee;
                $data->pph = $pph;
                $data->jumlah_pph = $jumlah_pph;
                $data->save();

                // Debit
                if(!empty($premi_netto)){
                    $new = new \App\Models\Expenses();
                    $new->nominal = $premi_netto;
                    $new->recipient = $pemegang_polis;
                    $new->reference_type = 'Premi Netto';
                    $new->reference_no = $no_reg;
                    $new->reference_date = $tanggal_produksi;
                    $new->policy_id = $polis->id;
                    $new->save();
                }
                // Debit
                if(!empty($jml_discount)){
                    $new = new \App\Models\Expenses();
                    $new->nominal = $premi_netto;
                    $new->recipient = $pemegang_polis;
                    $new->reference_type = 'Diskon';
                    $new->reference_no = $no_reg;
                    $new->reference_date = $tanggal_produksi;
                    $new->policy_id = $polis->id;
                    $new->save();
                }
                // kredit
                if(!empty($premi_gross) or !empty($extra_premi)){
                    $new = new \App\Models\Income();
                    $new->teknis_id = $data->id;
                    $new->debit_note = $no_reg;
                    $new->nominal = $premi_gross+$extra_premi;
                    $new->policy_id = $polis->id;
                    $new->save();
                }
                // kredit
                if(!empty($jumlah_pph)){
                    $new = new \App\Models\Income();
                    $new->teknis_id = $data->id;
                    $new->debit_note = $no_reg;
                    $new->debit_note_date = $tanggal_produksi;
                    $new->nominal = $jumlah_pph;
                    $new->policy_id = $polis->id;
                    $new->save();       
                }
                // kredit
                if($extsertifikat!=""){
                    $new = new \App\Models\Income();
                    $new->teknis_id = $data->id;
                    $new->debit_note = $no_reg;
                    $new->nominal = $extsertifikat;
                    $new->debit_note_date = $tanggal_produksi;
                    $new->policy_id = $polis->id;
                    $new->save();    
                }
            }
            
            session()->flash('message-success','Upload success !');
            
            return redirect()->to('data-teknis');
        }
    }
}
