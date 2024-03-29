<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldNameBankNumberToExpensPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expense_payments', function (Blueprint $table) {
            $table->string('bank',100)->nullable();
            $table->string('name',100)->nullable();
            $table->string('account_number',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expens_payment', function (Blueprint $table) {
            //
        });
    }
}
