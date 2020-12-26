<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTotalKreditTotalDebit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income', function (Blueprint $table) {
            $table->bigInteger('total_debit')->default(0)->nullable();
            $table->bigInteger('total_kredit')->default(0)->nullable();
        });
        
        Schema::table('expenses', function (Blueprint $table) {
            $table->bigInteger('total_debit')->default(0)->nullable();
            $table->bigInteger('total_kredit')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income', function (Blueprint $table) {
            //
        });
    }
}
