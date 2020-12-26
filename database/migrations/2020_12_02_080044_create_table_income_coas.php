<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableIncomeCoas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_coas', function (Blueprint $table) {
            $table->id();
            $table->integer('income_id')->nullable();
            $table->integer('coa_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('debit')->nullable();
            $table->date('payment_date')->nullable();
            $table->integer('kredit')->nullable();
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
        Schema::dropIfExists('income_coas');
    }
}
