<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableJournal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->integer('coa_id');
            $table->string('no_vocher',255)->nullable();
            $table->date('date_journal');
            $table->bigInteger('debit');
            $table->bigInteger('kredit');
            $table->bigInteger('saldo');
            $table->smallInteger('type_journal')->nullable();
            $table->integer('code_cashflow_id')->nullable();
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
        Schema::dropIfExists('journal');
    }
}
