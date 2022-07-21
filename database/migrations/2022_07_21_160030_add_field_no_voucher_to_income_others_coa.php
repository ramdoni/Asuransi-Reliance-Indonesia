<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldNoVoucherToIncomeOthersCoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_others_coa', function (Blueprint $table) {
            $table->string('no_voucher')->nullable();
        });

        Schema::table('expense_others_coa', function (Blueprint $table) {
            $table->string('no_voucher')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income_others_coa', function (Blueprint $table) {
            //
        });
    }
}
