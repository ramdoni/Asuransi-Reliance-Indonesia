<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnJournalDateKonvenUw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konven_underwriting', function (Blueprint $table) {
            $table->date('date_journal')->nullable();
            $table->integer('bank_account_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konven_underwriting', function (Blueprint $table) {
            //
        });
    }
}
