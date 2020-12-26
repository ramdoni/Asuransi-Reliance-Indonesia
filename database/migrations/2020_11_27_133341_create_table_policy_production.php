<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePolicyProduction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policys', function (Blueprint $table) {
            $table->id();
            $table->string('no_polis',50)->nullable();
            $table->string('no_polis_sistem',50)->nullable();
            $table->text('pemegang_polis')->nullable();
            $table->text('alamat')->nullable();
            $table->string('cabang',255)->nullable();
            $table->string('produk',255)->nullable();
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
        Schema::dropIfExists('policys');
    }
}
