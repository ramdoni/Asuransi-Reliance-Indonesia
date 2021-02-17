<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnExpensePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_payments', function (Blueprint $table) {
            $table->string('transaction_type')->change();
            $table->renameColumn('bank_account_id','from_bank_account_id');
            $table->integer('to_bank_account_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expense_payment', function (Blueprint $table) {
            //
        });
    }
}
