<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('contests')->onDelete('cascade');
            $table->foreignUuid('grade_id')->references('uuid')->on('grades')->onDelete('cascade');
            $table->foreignUuid('subject_id')->references('uuid')->on('subjects')->onDelete('cascade');
            $table->foreignUuid('student_id')->references('uuid')->on('students')->onDelete('cascade');
            $table->integer('ca1')->nullable();
            $table->integer('ca2')->nullable();
            $table->integer('ca3')->nullable();
            $table->integer('exam')->nullable();
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
        Schema::dropIfExists('results');
    }
}