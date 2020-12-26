<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKonvenUnderwritingCoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konven_underwriting_coa', function (Blueprint $table) {
            $table->id();
            $table->integer('konven_underwriting_id')->nullable();
            $table->integer('coa_id')->nullable();
            $table->bigInteger('debit')->nullable();
            $table->bigInteger('kredit')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('konven_underwriting_coa');
    }
}
