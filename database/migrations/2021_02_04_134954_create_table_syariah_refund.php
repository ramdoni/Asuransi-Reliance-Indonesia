<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSyariahRefund extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syariah_refund', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('is_temp')->default(0)->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('bulan',20)->nullable();
            $table->string('user_memo',50)->nullable();
            $table->string('user_akseptasi',50)->nullable();
            $table->string('berkas_akseptasi',5)->nullable();
            $table->date('tgl_pengajuan_email')->nullable();
            $table->date('tgl_refund')->nullable();
            $table->string('no_memo',100)->nullable();
            $table->string('no_credit_note',100)->nullable();
            $table->string('no_polis',50)->nullable();
            $table->text('pemegang_polis')->nullable();
            $table->text('alamat')->nullable();
            $table->text('cabang')->nullable();
            $table->text('jenis_produk')->nullable();
            $table->string('tujuan_pembayaran',150)->nullable();
            $table->string('bank',100)->nullable();
            $table->string('no_rekening',50)->nullable();
            $table->string('jml_kepesertaan_tertunda',10)->nullable();
            $table->integer('manfaat_kepesertaan_tertunda')->nullable();
            $table->integer('kontribusi_kepesertaan_tertunda')->nullable();
            $table->string('jumlah_kepesertaan',10)->nullable();
            $table->string('no_kepesertaan_awal',50)->nullable();
            $table->string('no_kepesertaan_akhir',50)->nullable();
            $table->date('masa_awal')->nullable();
            $table->date('masa_akhir')->nullable();
            $table->date('tgl_produksi')->nullable();
            $table->string('no_debit_note_terakseptasi',100)->nullable();
            $table->bigInteger('kontribusi_dn')->nullable();
            $table->bigInteger('manfaat_asuransi')->nullable();
            $table->bigInteger('kontribusi')->nullable();
            $table->bigInteger('refund_kontribusi')->nullable();
            $table->text('terbilang')->nullable();
            $table->text('ket_lampiran')->nullable();
            $table->string('grace_periode',25)->nullable();
            $table->string('grace_periode_num',10)->nullable();
            $table->date('tgl_jatoh_tempo')->nullable();
            $table->date('tgl_update_database')->nullable();
            $table->date('tgl_bayar')->nullable();
            $table->text('ket')->nullable();
            $table->text('ket_2')->nullable();
            $table->text('ket_reas')->nullable();
            $table->date('tgl_bayar_reas')->nullable();
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
        Schema::dropIfExists('syariah_refund');
    }
}
