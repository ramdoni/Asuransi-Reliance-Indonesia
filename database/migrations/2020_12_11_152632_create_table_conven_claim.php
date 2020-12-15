<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableConvenClaim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konven_claim', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_polis',50)->nullable();
            $table->string('nama_pemegang',250)->nullable();
            $table->string('nomor_partipisan',50)->nullable();
            $table->string('nama_partipisan',150)->nullable();
            $table->bigInteger('nilai_klaim')->nullable();
            $table->bigInteger('or')->nullable();
            $table->bigInteger('reas')->nullable();
            $table->string('status',10)->nullable();
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
        Schema::dropIfExists('konven_claim');
    }
}
