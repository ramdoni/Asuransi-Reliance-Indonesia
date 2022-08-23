<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldMinusPlusToBankBooksSummary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_books_summary', function (Blueprint $table) {
            $table->bigInteger('kredit')->nullable();
            $table->bigInteger('debit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_books_summary', function (Blueprint $table) {
            //
        });
    }
}
