<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCoaGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coa_groups', function (Blueprint $table) {
            $table->id();
            $table->string('code',100)->nullable();
            $table->string('name',200)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('coas', function (Blueprint $table) {
            $table->id();
            $table->integer('coa_group_id')->nullable();
            $table->string('code',100)->nullable();
            $table->string('name',200)->nullable();
            $table->integer('coa_type_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('coa_types', function (Blueprint $table) {
            $table->id();
            $table->string('name',200)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('coa_group');
    }
}
