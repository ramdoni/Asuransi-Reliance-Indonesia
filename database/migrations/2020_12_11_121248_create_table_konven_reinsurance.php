<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKonvenReinsurance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konven_reinsurance', function (Blueprint $table) {
            $table->id();
            $table->string('no_polis',100)->nullable();
            $table->string('pemegang_polis',250)->nullable();
            $table->string('peserta',10)->nullable();
            $table->bigInteger('uang_pertanggungan')->nullable();
            $table->bigInteger('uang_pertanggungan_reas')->nullable();
            $table->bigInteger('premi_gross_ajri')->nullable();
            $table->integer('premi_reas')->nullable();
            $table->integer('komisi_reinsurance')->nullable();
            $table->integer('premi_reas_netto')->nullable();
            $table->string('keterangan',200)->nullable();
            $table->string('kirim_reas',100)->nullable();
            $table->string('broker_re',100)->nullable();
            $table->string('reasuradur',100)->nullable();
            $table->string('bulan',10)->nullable();
            $table->string('ekawarsa_jangkawarsa',50)->nullable();
            $table->string('produk',100)->nullable();
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
        Schema::dropIfExists('konven_reinsurance');
    }
}
