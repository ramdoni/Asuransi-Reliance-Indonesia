<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTeknis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teknis', function (Blueprint $table) {
            $table->string('no_reg',255)->nullable();
            $table->string('no_polis_sistem',100)->nullable();
            $table->bigInteger('premi_gross')->nullable();
            $table->smallInteger('discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teknis', function (Blueprint $table) {
            //
        });
    }
}
