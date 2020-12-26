<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTetapMenurunKonvenReinsurance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konven_reinsurance', function (Blueprint $table) {
            $table->string('tetap_menurun',50)->nullable();
        });
        Schema::table('income', function (Blueprint $table) {
            $table->date('payment_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konven_reinsurance', function (Blueprint $table) {
            //
        });
    }
}
