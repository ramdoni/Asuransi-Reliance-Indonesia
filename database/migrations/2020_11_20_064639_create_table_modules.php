<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });

        Schema::create('modules_items', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id')->nullable();
            $table->string('name',255)->nullable();
            $table->text('link')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('modules');
    }
}
