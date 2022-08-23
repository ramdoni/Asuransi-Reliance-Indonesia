<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBankBooksSummary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_books_summary', function (Blueprint $table) {
            $table->id();
            $table->date('date_summary')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->bigInteger('amount_before')->nullable();
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
        Schema::dropIfExists('bank_books_summary');
    }
}
