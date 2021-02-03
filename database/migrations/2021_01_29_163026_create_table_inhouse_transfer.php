<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableInhouseTransfer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inhouse_transfer', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('from_bank_account_id')->nullable();
            $table->integer('to_bank_account_id')->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->text('attach')->nullable();
            $table->date('transaction_date')->nullable();
            $table->timestamps();
        });
        Schema::create('bank_account_balance', function (Blueprint $table) {
            $table->id();
            $table->integer('bank_account_id')->nullable();
            $table->string('type',100)->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('inhouse_transfer');
    }
}
