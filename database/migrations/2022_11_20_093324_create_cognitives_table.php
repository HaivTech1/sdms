<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCognitivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cognitives', function (Blueprint $table) {
            $table->id();
            $table->float('attendance_duration')->nullable();
            $table->float('attendance_present')->nullable();
            $table->text('comment')->nullable();
            $table->foreignUuid('student_uuid')->references('uuid')->on('students')->onDelete('cascade');
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
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
        Schema::dropIfExists('cognitives');
    }
}
