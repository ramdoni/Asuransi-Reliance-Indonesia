<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKonvenConvenMemoPos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konven_memo_pos', function (Blueprint $table) {
            $table->id();
            $table->string('bulan',25)->nullable();
            $table->string('user',50)->nullable();
            $table->string('user_akseptasi',50)->nullable();
            $table->string('berkas_akseptasi',12)->nullable();
            $table->date('tgl_pengajuan_email')->nullable();
            $table->date('tgl_produksi')->nullable();
            $table->string('no_reg',100)->nullable();
            $table->string('no_reg_sistem',100)->nullable();
            $table->string('no_dn_cn',100)->nullable();
            $table->string('no_dn_cn_sistem',100)->nullable();
            $table->string('jenis_po',10)->nullable();
            $table->string('status',10)->nullable();
            $table->string('posting',20)->nullable();
            $table->string('jenis_po_2',10)->nullable();
            $table->text('ket_perubahan1')->nullable();
            $table->string('ket_perubahan2',5)->nullable();
            $table->string('no_polis',50)->nullable();
            $table->string('pemegang_polis',200)->nullable();
            $table->string('cabang',100)->nullable();
            $table->string('produk',100)->nullable();
            $table->text('alamat')->nullable();
            $table->text('up_tujuan_surat')->nullable();
            $table->string('tujuan_pembayaran',150)->nullable();
            $table->string('bank',50)->nullable();
            $table->string('no_rekening',25)->nullable();
            $table->integer('jumlah_peserta_pending')->nullable();
            $table->bigInteger('up_peserta_pending')->nullable();
            $table->bigInteger('premi_peserta_pending')->nullable();
            $table->smallInteger('peserta')->nullable();
            $table->string('no_peserta_awal',150)->nullable();
            $table->string('no_peserta_akhir',100)->nullable();
            $table->string('no_sertifikat_awal',100)->nullable();
            $table->string('no_sertifikat_akhir',100)->nullable();
            $table->date('periode_awal')->nullable();
            $table->date('periode_akhir')->nullable();
            $table->date('tgl_proses')->nullable();
            $table->string('movement',50)->nullable();
            $table->date('tgl_invoice')->nullable();
            $table->date('tgl_invoice2')->nullable();
            $table->string('no_kwitansi_finance',100)->nullable();
            $table->string('no_kwitansi_finance2',100)->nullable();
            $table->bigInteger('total_gross_kwitansi')->nullable();
            $table->bigInteger('total_gross_kwitansi2')->nullable();
            $table->smallInteger('jumlah_peserta_update')->nullable();
            $table->bigInteger('up_cancel')->nullable();
            $table->bigInteger('premi_gross_cancel')->nullable();
            $table->bigInteger('extra_premi')->nullable();
            $table->bigInteger('extextra')->nullable();
            $table->bigInteger('rpextra')->nullable();
            $table->smallInteger('diskon_premi')->nullable();
            $table->bigInteger('jml_diskon')->nullable();
            $table->string('rp_diskon',10)->nullable();
            $table->string('extdiskon',10)->nullable();
            $table->integer('fee')->nullable();
            $table->bigInteger('jml_handling_fee')->nullable();
            $table->bigInteger('ext_fee')->nullable();
            $table->string('rp_fee',10)->nullable();
            $table->string('tampilan_fee',100)->nullable();
            $table->smallInteger('pph')->nullable();
            $table->bigInteger('jml_pph')->nullable();
            $table->bigInteger('extpph')->nullable();
            $table->bigInteger('rppph')->nullable();
            $table->smallInteger('ppn')->nullable();
            $table->bigInteger('jml_ppn')->nullable();
            $table->string('extppn',25)->nullable();
            $table->bigInteger('rpppn')->nullable();
            $table->integer('biaya_sertifikat')->nullable();
            $table->integer('extbiayasertifikat')->nullable();
            $table->integer('rpbiayasertifikat')->nullable();
            $table->integer('extpstsertifikat')->nullable();
            $table->bigInteger('net_sblm_endors')->nullable();
            $table->smallInteger('data_stlh_endors')->nullable();
            $table->bigInteger('up_stlh_endors')->nullable();
            $table->bigInteger('premi_gross_endors')->nullable();
            $table->bigInteger('extra_premi2')->nullable();
            $table->integer('extem')->nullable();
            $table->string('rpxtra',25)->nullable();
            $table->smallInteger('discount')->nullable();
            $table->integer('jml_discount')->nullable();
            $table->string('ext_discount',25)->nullable();
            $table->string('rpdiscount',10)->nullable();
            $table->integer('handling_fee')->nullable();
            $table->integer('extfee')->nullable();
            $table->string('rpfee',10)->nullable();
            $table->string('tampilanfee',10)->nullable();
            $table->smallInteger('pph2')->nullable();
            $table->integer('jml_pph2')->nullable();
            $table->integer('extpph2')->nullable();
            $table->string('rppph2',10)->nullable();
            $table->smallInteger('ppn2')->nullable();
            $table->integer('jml_ppn2')->nullable();
            $table->string('extppn2',15)->nullable();
            $table->string('rpppn2',10)->nullable();
            $table->string('biaya_sertifikat2',15)->nullable();
            $table->integer('extbiayasertifikat2')->nullable();
            $table->string('rpbiayasertifikat2',10)->nullable();
            $table->string('extpstsertifikat2')->nullable();
            $table->bigInteger('net_stlh_endors')->nullable();
            $table->bigInteger('refund')->nullable();
            $table->bigInteger('terbilang')->nullable();
            $table->string('ket_lampiran',25)->nullable();
            $table->string('grace_periode',100)->nullable();
            $table->smallInteger('grace_periode_nominal')->nullable();
            $table->date('tgl_jatuh_tempo')->nullable();
            $table->date('tgl_update_database')->nullable();
            $table->date('tgl_update_sistem')->nullable();
            $table->string('no_berkas_sistem',100)->nullable();
            $table->date('tgl_posting_sistem')->nullable();
            $table->string('no_debit_note_finance')->nullable();
            $table->date('tgl_bayar')->nullable();
            $table->text('ket')->nullable();
            $table->date('tgl_output_email')->nullable();
            $table->smallInteger('no_berkas2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konven_memo_pos');
    }
}
