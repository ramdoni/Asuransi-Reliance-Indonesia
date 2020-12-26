<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableExpense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('no_vocher',255)->nullable();
            $table->string('recipient',255)->nullable();
            $table->string('refrence_type',100)->nullable();
            $table->string('refrence_no',100)->nullable();
            $table->date('refrence_date')->nullable();
            $table->text('description')->nullable();
            $table->integer('tax_id')->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->bigInteger('outstanding_balance')->nullable();
            $table->integer('coa_id')->nullable();
            $table->bigInteger('payment_amount')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('rekening_bank_id')->nullable();
            $table->timestamps();
        });

        Schema::create('income', function (Blueprint $table) {
            $table->id();
            $table->integer('teknis_id')->nullable();
            $table->string('no_vocher',255)->nullable();
            $table->string('debit_note',255)->nullable();
            $table->date('debit_note_date')->nullable();
            $table->integer('policy_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('tax_id')->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->bigInteger('outstanding_balance')->nullable();
            $table->integer('coa_id')->nullable();
            $table->bigInteger('payment_amount')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('rekening_bank_id')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
