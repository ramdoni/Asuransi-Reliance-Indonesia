<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSyariahEndorsement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syariah_endorsement', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('is_temp')->default(0)->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('bulan',20)->nullable();
            $table->string('user_memo',50)->nullable();
            $table->string('berkas_akseptasi',10)->nullable();
            $table->date('tgl_pengajuan_email')->nullable();
            $table->date('tgl_endors')->nullable();
            $table->string('no_memo',100)->nullable();
            $table->string('no_dn_cn',100)->nullable();
            $table->string('jenis_perubahan',100)->nullable();
            $table->string('no_polis',50)->nullable();
            $table->text('pemegang_polis')->nullable();
            $table->text('cabang')->nullable();
            $table->text('nama_produk')->nullable();
            $table->text('alamat')->nullable();
            $table->string('tujuan_pembayaran',150)->nullable();
            $table->string('bank',100)->nullable();
            $table->string('no_rekening',50)->nullable();
            $table->string('grace_periode',50)->nullable();
            $table->string('jumlah_kepesertaan',10)->nullable();
            $table->string('no_kepesertaan_awal',50)->nullable();
            $table->string('no_kepesertaan_akhir',50)->nullable();
            $table->string('jumlah_kepesertaan_sebelum_endors',10)->nullable();
            $table->bigInteger('manfaat_sebelum_endors')->nullable();
            $table->bigInteger('dana_tab_baru_sebelum_endors')->nullable();
            $table->bigInteger('dana_ujrah_sebelum_endors')->nullable();
            $table->bigInteger('kontribusi_cancel')->nullable();
            $table->integer('extra_kontribusi')->nullable();
            $table->string('discount',10)->nullable();
            $table->integer('jumlah_discount')->nullable();
            $table->integer('handling_fee')->nullable();
            $table->integer('jumlah_fee')->nullable();
            $table->string('pph',10)->nullable();
            $table->integer('jumlah_pph')->nullable();
            $table->string('ppn',10)->nullable();
            $table->integer('jumlah_ppn')->nullable();
            $table->bigInteger('biaya_polis')->nullable();
            $table->integer('biaya_sertifikat')->nullable();
            $table->integer('ext_biaya_sertifikat')->nullable();
            $table->integer('rp_biaya_sertifikat')->nullable();
            $table->integer('ext_pst_sertifikat')->nullable();
            $table->bigInteger('net_sebelum_endors')->nullable();
            $table->string('Jumlah_kepesertaan_setelah_endors',10)->nullable();
            $table->bigInteger('manfaat_setelah_endors')->nullable();
            $table->bigInteger('dana_tab_baru_setelah_endors')->nullable();
            $table->bigInteger('dana_ujrah_setelah_endors')->nullable();
            $table->bigInteger('kontribusi_endors')->nullable();
            $table->integer('extra_kontribusi_2')->nullable();
            $table->string('discount_2',10)->nullable();
            $table->integer('jumlah_discount_2')->nullable();
            $table->integer('handling_fee_2')->nullable();
            $table->integer('jumlah_fee_2')->nullable();
            $table->string('pph_2',10)->nullable();
            $table->integer('jumlah_pph_2')->nullable();
            $table->string('ppn_2',10)->nullable();
            $table->integer('jumlah_ppn_2')->nullable();
            $table->integer('biaya_polis_2')->nullable();
            $table->integer('biaya_sertifikat_2')->nullable();
            $table->integer('net_setelah_endors')->nullable();
            $table->bigInteger('dengan_tagihan_atau_refund_premi')->nullable();
            $table->text('terbilang')->nullable();
            $table->string('grace_periode_2',5)->nullable();
            $table->date('tgl_jatoh_tempo')->nullable();
            $table->date('tgl_update_database')->nullable();
            $table->date('tgl_bayar')->nullable();
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
        Schema::dropIfExists('syariah_endorsement');
    }
}
