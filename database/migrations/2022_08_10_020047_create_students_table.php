<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_name')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->timestamp('dob');
            $table->string('nationality')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('local_government')->nullable();
            $table->string('address')->nullable();
            $table->string('prev_school')->nullable();
            $table->string('prev_class')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('religion')->nullable();
            $table->text('denomination')->nullable();
            $table->text('blood_group')->nullable();
            $table->text('genotype')->nullable();
            $table->text('speech_development')->nullable();
            $table->text('sight')->nullable();
            $table->text('allergics')->nullable();
            $table->enum('type', ['n', 's', 'scholarship'])->default('n');
            $table->foreignId('grade_id')->nullable()->constrained('grades')->onDelete('set null');
            $table->foreignId('sub_grade_id')->nullable()->constrained('sub_grades')->onDelete('set null');
            $table->foreignId('house_id')->nullable()->constrained('houses')->onDelete('set null');
            $table->foreignId('club_id')->nullable()->constrained('clubs')->onDelete('set null');
            $table->foreignId('registration_id')->nullable()->constrained('registrations')->onDelete('set null');
            $table->boolean('status')->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('students');
    }
}