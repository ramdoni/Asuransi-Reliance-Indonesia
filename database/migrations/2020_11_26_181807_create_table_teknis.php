<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTeknis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teknis', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type_transaksi')->default(1)->nullable();
            $table->integer('user_id')->nullable();
            $table->boolean('status')->nullable();
            $table->string('bulan',20)->nullable();
            $table->string('user_memo',50)->nullable();
            $table->string('user_akseptasi',50)->nullable();
            $table->string('transaksi_id',100)->nullable();
            $table->string('berkas_akseptasi',10)->nullable();
            $table->date('tanggal_pengajuan_email')->nullable();
            $table->date('tanggal_produksi')->nullable();
            $table->date('tanggal_akrual')->nullable();
            $table->string('bordero',50)->nullable();
            $table->string('no_memo',50)->nullable();
            $table->string('no_debit_note',50)->nullable();
            $table->string('no_polis',150)->nullable();
            $table->string('pemegang_polis',150)->nullable();
            $table->text('alamat')->nullable();
            $table->text('cabang')->nullable();
            $table->string('jenis_produk',100)->nullable();
            $table->string('jml_kepesertaan_tertunda',10)->nullable();
            $table->integer('manfaat_Kepesertaan_tertunda')->nullable();
            $table->integer('kontribusi_kepesertaan_tertunda')->nullable();
            $table->integer('jml_kepesertaan')->nullable();
            $table->string('no_kepesertaan_awal',20)->nullable();
            $table->string('no_kepesertaan_akhir',20)->nullable();
            $table->date('masa_awal_asuransi')->nullable();
            $table->date('masa_akhir_asuransi')->nullable();
            $table->integer('nilai_manfaat')->nullable();
            $table->integer('dana_tabbaru')->nullable();
            $table->integer('dana_ujrah')->nullable();
            $table->integer('kontribusi')->nullable();
            $table->integer('ektra_kontribusi')->nullable();
            $table->integer('total_kontribusi')->nullable();
            $table->integer('pot_langsung')->nullable();
            $table->integer('jumlah_diskon')->nullable();
            $table->string('status_potongan',10)->nullable();
            $table->integer('handling_fee')->nullable();
            $table->integer('jumlah_fee')->nullable();
            $table->integer('pph')->nullable();
            $table->integer('jumlah_pph')->nullable();
            $table->integer('ppn')->nullable();
            $table->integer('jumlah_ppn')->nullable();
            $table->integer('biaya_polis')->nullable();
            $table->integer('biaya_sertifikat')->nullable();
            $table->integer('extpst')->nullable();
            $table->integer('net_kontribusi')->nullable();
            $table->string('terbilang',200)->nullable();
            $table->date('tgl_update_database')->nullable();
            $table->date('tgl_update_sistem')->nullable();
            $table->integer('no_berkas_sistem')->nullable();
            $table->date('tgl_posting_sistem')->nullable();
            $table->text('ket_posting')->nullable();
            $table->string('grace_periode',20)->nullable();
            $table->smallInteger('grace_periode_number')->nullable();
            $table->date('tgl_jatuh_tempo')->nullable();
            $table->date('tgl_lunas')->nullable();
            $table->integer('pembayaran')->nullable();
            $table->integer('piutang')->nullable();
            $table->tinyInteger('total_peserta')->nullable();
            $table->tinyInteger('outstanding_peserta')->nullable();
            $table->string('produksi_cash_basis',10)->nullable();
            $table->string('ket_lampiran',30)->nullable();
            $table->string('masa_asuransi',8)->nullable();
            $table->integer('kontribusi_netto_u_biaya_penutupan')->nullable();
            $table->string('perkalian_biaya_penutupan',30)->nullable();
            $table->string('bp',5)->nullable();
            $table->integer('total_biaya_penutupan')->nullable();
            $table->text('ket_penutupan')->nullable();
            $table->string('tahun',4)->nullable();
            $table->string('peserta_reas',4)->nullable();
            $table->string('nilai_manfaat_or',20)->nullable();
            $table->string('kontribusi_gross_reas',20)->nullable();
            $table->string('ujroh',20)->nullable();
            $table->string('extra_mortalita',20)->nullable();
            $table->string('total_kontribusi_reas',20)->nullable();
            $table->string('kontribusi_netto_reas',20)->nullable();
            $table->string('produksi_reas_akrual',10)->nullable();
            $table->text('internal_memo_reas')->nullable();
            $table->text('invoice_reas')->nullable();
            $table->date('tgl_pembayaran_kontribusi_reas')->nullable();
            $table->date('produksi_reas_cash_basis')->nullable();
            $table->text('ket_reas')->nullable();
            $table->string('reasuradur',20)->nullable();
            $table->string('channel',20)->nullable();
            $table->string('gross_ajri_peserta_yang_direaskan',20)->nullable();
            $table->timestamps();
        });

        Schema::create('teknis_transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer('teknis_id')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('nominal')->nullable();
            $table->integer('coa_id')->nullable();
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
        Schema::dropIfExists('teknis');
    }
}
