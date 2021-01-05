<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKonvenUnderwritingCancelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konven_underwriting_cancelations', function (Blueprint $table) {
            $table->id();
            $table->integer('konven_underwriting_id')->nullable();
            $table->integer('konven_memo_pos_id')->nullable();
            $table->integer('income_id')->nullable();
            $table->bigInteger('nominal')->nullable();
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
        Schema::dropIfExists('konven_underwriting_cancelations');
    }
}
