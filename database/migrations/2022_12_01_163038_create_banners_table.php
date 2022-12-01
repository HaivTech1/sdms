<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('wide_banner')->nullable();
            $table->string('feature_one_title')->nullable();
            $table->string('feature_two_title')->nullable();
            $table->string('feature_three_title')->nullable();
            $table->string('feature_one')->nullable();
            $table->string('feature_two')->nullable();
            $table->string('feature_three')->nullable();
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
        Schema::dropIfExists('banners');
    }
}
