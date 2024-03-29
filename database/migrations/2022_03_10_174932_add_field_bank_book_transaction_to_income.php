<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldBankBookTransactionToIncome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income', function (Blueprint $table) {
            $table->integer('bank_book_transaction_id')->nullable();

            $table->index(['bank_book_transaction_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income', function (Blueprint $table) {
            //
        });
    }
}
