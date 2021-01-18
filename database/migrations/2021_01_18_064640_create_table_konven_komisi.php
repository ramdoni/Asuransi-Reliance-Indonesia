<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKonvenKomisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konven_komisi', function (Blueprint $table) {
            $table->id();
            $table->string('user',100)->nullable();
            $table->date('tgl_memo')->nullable();
            $table->string('no_reg',150)->nullable();
            $table->string('no_polis',150)->nullable();
            $table->string('no_polis_sistem',150)->nullable();
            $table->string('pemegang_polis',150)->nullable();
            $table->string('produk',250)->nullable();
            $table->date('tgl_invoice')->nullable();
            $table->string('no_kwitansi',100)->nullable();
            $table->integer('total_peserta')->nullable();
            $table->string('no_peserta',100)->nullable();
            $table->bigInteger('total_up')->nullable();
            $table->bigInteger('total_premi_gross')->nullable();
            $table->string('em',50)->nullable();
            $table->integer('disc_pot_langsung')->nullable();
            $table->bigInteger('premi_netto_yg_dibayarkan')->nullable();
            $table->bigInteger('perkalian_biaya_penutupan')->nullable();
            $table->tinyInteger('fee_base')->nullable();
            $table->integer('biaya_fee_base')->nullable();
            $table->integer('maintenance')->nullable();
            $table->integer('biaya_maintenance')->nullable();
            $table->integer('admin_agency')->nullable();
            $table->integer('biaya_admin_agency')->nullable();
            $table->tinyInteger('agen_penutup')->nullable();
            $table->integer('biaya_agen_penutup')->nullable();
            $table->tinyInteger('operasional_agency')->nullable();
            $table->integer('biaya_operasional_agency')->nullable();
            $table->tinyInteger('handling_fee_broker')->nullable();
            $table->integer('biaya_handling_fee_broker')->nullable();
            $table->tinyInteger('referral_fee')->nullable();
            $table->integer('biaya_rf')->nullable();
            $table->tinyInteger('pph')->nullable();
            $table->integer('jumlah_pph')->nullable();
            $table->tinyInteger('ppn')->nullable();
            $table->integer('jumlah_ppn')->nullable();
            $table->integer('cadangan_klaim')->nullable();
            $table->integer('jml_cadangan_klaim')->nullable();
            $table->integer('klaim_kematian')->nullable();
            $table->integer('pembatalan')->nullable();
            $table->bigInteger('total_komisi')->nullable();
            $table->string('tujuan_pembayaran',150)->nullable();
            $table->string('no_rekening',50)->nullable();
            $table->date('tgl_lunas')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('konven_underwriting_id')->nullable();
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
        Schema::dropIfExists('konven_komisi');
    }
}
