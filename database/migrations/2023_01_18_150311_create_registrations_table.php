<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
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
            $table->foreignId('grade_id')->nullable()->constrained('grades')->onDelete('set null');
            $table->boolean('status')->default(0);
            $table->text('image')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_email')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('father_office_address')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('mother_office_address')->nullable();
            $table->string('guardian_full_name')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('guardian_phone_number')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->string('guardian_office_address')->nullable();
            $table->string('guardian_home_address')->nullable();
            $table->string('guardian_relationship')->nullable();
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
        Schema::dropIfExists('registrations');
    }
}
