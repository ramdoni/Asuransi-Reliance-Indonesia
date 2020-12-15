<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnTableIncomeClaim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konven_claim', function (Blueprint $table) {
            $table->renameColumn('nomor_partipisan','nomor_partisipan');
            $table->renameColumn('nama_partipisan','nama_partisipan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income_claim', function (Blueprint $table) {
            //
        });
    }
}
