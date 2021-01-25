<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldIsTempParentIdtKonvenUnderwriting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konven_underwriting', function (Blueprint $table) {
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
        Schema::table('konven_underwriting', function (Blueprint $table) {
            //
        });
    }
}
