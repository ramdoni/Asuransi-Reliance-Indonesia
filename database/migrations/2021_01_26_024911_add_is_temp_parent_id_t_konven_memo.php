<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsTempParentIdTKonvenMemo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konven_memo_pos', function (Blueprint $table) {
            $table->integer('parent_id')->nullable();
            $table->boolean('is_temp')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konven_memoPos', function (Blueprint $table) {
            //
        });
    }
}
