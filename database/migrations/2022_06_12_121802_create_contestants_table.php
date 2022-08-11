<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contestants', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->unique();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('state')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('height')->nullable();
            $table->string('waist')->nullable();
            $table->longText('image')->nullable();
            $table->dateTime('dob')->nullable();
            $table->text('description');
            $table->foreignId('contest_id')->constrained('contests')->onDelete('cascade');
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
        Schema::dropIfExists('contestants');
    }
}