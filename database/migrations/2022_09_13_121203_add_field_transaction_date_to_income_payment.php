<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTransactionDateToIncomePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_payments', function (Blueprint $table) {
            $table->date('transaction_date')->nullable();
        });

        Schema::table('expense_payments', function (Blueprint $table) {
            $table->date('transaction_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income_payment', function (Blueprint $table) {
            //
        });
    }
}
