<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableIncomeCancel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_cancels', function (Blueprint $table) {
            $table->id();
            $table->integer('income_id')->nullable();
            $table->integer('transaction_id')->nullable();
            $table->string('transaction_table',100)->nullable();
            $table->bigInteger('nominal')->nullable();
            $table->string('no_cn',100)->nullable();
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
        Schema::table('income_cancels', function (Blueprint $table) {
            //
        });
    }
}
