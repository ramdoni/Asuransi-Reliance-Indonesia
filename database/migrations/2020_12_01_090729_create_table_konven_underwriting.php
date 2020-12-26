<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKonvenUnderwriting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konven_underwriting', function (Blueprint $table) {
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
            $table->string('no_reg',255)->nullable();
            $table->string('no_polis',150)->nullable();
            $table->string('no_polis_sistem',100)->nullable();
            $table->string('pemegang_polis',150)->nullable();
            $table->text('alamat')->nullable();
            $table->text('cabang')->nullable();
            $table->string('jumla_peserta_pending',10)->nullable();
            $table->string('up_peserta_pending',10)->nullable();
            $table->string('premi_peserta_pending',20)->nullable();
            $table->string('jumlah_peserta',8)->nullable();
            $table->string('nomor_peserta_awal',100)->nullable();
            $table->date('periode_awal')->nullable();
            $table->date('periode_akhir')->nullable();
            $table->bigInteger('up')->nullable();
            $table->bigInteger('premi_gross')->nullable();
            $table->bigInteger('extra_premi')->nullable();
            $table->smallInteger('discount')->nullable();
            $table->integer('jumlah_discount')->nullable();
            $table->integer('jumlah_cad_klaim')->nullable();
            $table->string('ext_diskon',50)->nullable();
            $table->string('cad_klaim',50)->nullable();
            $table->integer('handling_fee')->nullable();
            $table->integer('jumlah_fee')->nullable();
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
        Schema::dropIfExists('konven_underwriting');
    }
}
