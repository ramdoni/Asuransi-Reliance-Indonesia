<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDebitKreditTBankAccountBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_account_balance', function (Blueprint $table) {
            $table->integer('debit')->default(0)->nullable();
            $table->integer('kredit')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_account_balance', function (Blueprint $table) {
            //
        });
    }
}