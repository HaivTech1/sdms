<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('alias')->nullable();
            $table->string('email')->nullable();
            $table->string('line1')->nullable();
            $table->string('line2')->nullable();
            $table->string('image')->nullable();
            $table->string('fav')->nullable();
            $table->string('address')->nullable();
            $table->string('slogan')->nullable();
            $table->string('motto')->nullable();
            $table->string('regNo')->nullable();
            $table->text('description')->nullable();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('twitter')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('website')->nullable();
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
        Schema::dropIfExists('applications');
    }
}