<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableIncomeOthersCoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_others_coa', function (Blueprint $table) {
            $table->id();
            $table->integer('income_id')->nullable();
            $table->integer('coa_id')->nullable();
            $table->string('description',255)->nullable();
            $table->bigInteger('debit')->nullable();
            $table->bigInteger('kredit')->nullable();
            $table->timestamps();
        });

        Schema::create('expense_others_coa', function (Blueprint $table) {
            $table->id();
            $table->integer('expense_id')->nullable();
            $table->integer('coa_id')->nullable();
            $table->string('description',255)->nullable();
            $table->bigInteger('debit')->nullable();
            $table->bigInteger('kredit')->nullable();
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
        Schema::dropIfExists('income_others_coa');
    }
}
