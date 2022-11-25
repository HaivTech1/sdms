<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->time('time_in');
            $table->time('time_out');
            $table->timestamps();
        });

        Schema::create('schedule_students', function (Blueprint $table) {
            $table->foreignUuid('student_uuid')->references('uuid')->on('students')->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('schedule_students');
    }
}
