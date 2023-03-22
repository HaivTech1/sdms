<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHairstylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hairstyles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullble();
            $table->text('description')->nullble();
            $table->string('front_view')->nullble();
            $table->string('back_view')->nullble();
            $table->string('side_view')->nullble();
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
        Schema::dropIfExists('hairstyles');
    }
}
