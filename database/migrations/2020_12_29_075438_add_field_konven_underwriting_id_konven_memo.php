<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldKonvenUnderwritingIdKonvenMemo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konven_memo_pos', function (Blueprint $table) {
            $table->integer('konven_underwriting_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konven_memo_pos', function (Blueprint $table) {
            //
        });
    }
}
