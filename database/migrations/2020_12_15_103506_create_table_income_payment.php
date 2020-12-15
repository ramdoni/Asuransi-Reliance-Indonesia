<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableIncomePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('income_id');
            $table->bigInteger('payment_amount')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('bank_account_id')->nullable();
            $table->timestamps();
        });
        Schema::create('expense_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('expense_id');
            $table->bigInteger('payment_amount')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('bank_account_id')->nullable();
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
        Schema::dropIfExists('income_payments');
    }
}
