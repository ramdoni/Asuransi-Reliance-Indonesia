<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableIncomePeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_pesertas', function (Blueprint $table) {
            $table->id();
            $table->integer('income_id')->nullable();
            $table->string('no_peserta',100)->nullable();
            $table->string('nama_peserta',255)->nullable();
            $table->boolean('type')->nullable()->comment = "1 = Recovery Refund, etc";
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
        Schema::dropIfExists('income_pesertas');
    }
}
