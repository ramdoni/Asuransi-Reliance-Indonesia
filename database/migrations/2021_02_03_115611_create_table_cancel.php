<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCancel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syariah_cancel', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('is_temp')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('bulan',20)->nullable();
            $table->string('user_memo',50)->nullable();
            $table->string('user_akseptasi',50)->nullable();
            $table->string('no_berkas',5)->nullable();
            $table->date('tgl_pengajuan_email')->nullable();
            $table->date('tgl_cancel')->nullable();
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
            $table->string('jml_manfaat_kepesertaan_tertunda',10)->nullable();
            $table->string('jml_kontribusi_kepesertaan_tertunda',10)->nullable();
            $table->string('jumlah_kepesertaan',10)->nullable();
            $table->string('no_kepesertaan_awal',50)->nullable();
            $table->string('no_kepesertaan_akhir',50)->nullable();
            $table->date('masa_awal')->nullable();
            $table->date('masa_akhir')->nullable();
            $table->bigInteger('manfaat_cancel')->nullable();
            $table->bigInteger('kontribusi_gross_cancel')->nullable();
            $table->bigInteger('ektra_kontribusi_cancel')->nullable();
            $table->string('diskon_kontribusi',10)->nullable();
            $table->integer('jumlah_diskon')->nullable();
            $table->string('ppn',10)->nullable();
            $table->integer('jumlah_ppn')->nullable();
            $table->integer('fee')->nullable();
            $table->integer('jumlah_handling_fee')->nullable();
            $table->string('pph',10)->nullable();
            $table->integer('jumlah_pph')->nullable();
            $table->bigInteger('refund')->nullable();
            $table->text('terbilang')->nullable();
            $table->string('grace_periode',25)->nullable();
            $table->string('grace_periode_num',10)->nullable();
            $table->date('tgl_jatoh_tempo')->nullable();
            $table->date('tgl_update_database')->nullable();
            $table->string('no_debit_note',100)->nullable();
            $table->date('tgl_debit_note')->nullable();
            $table->bigInteger('kontribusi_debit_note')->nullable();
            $table->date('tgl_bayar_refund')->nullable();
            $table->text('ket')->nullable();
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
        Schema::dropIfExists('syariah_cancel');
    }
}
