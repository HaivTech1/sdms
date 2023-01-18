<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMidTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mid_terms', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->unique();
            $table->integer('entry_1')->nullable();
            $table->integer('entry_2')->nullable();
            $table->integer('first_test')->nullable();
            $table->integer('ca')->nullable();
            $table->integer('project')->nullable();
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignUuid('student_id')->references('uuid')->on('students')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->boolean('published')->default(0);
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
        Schema::dropIfExists('mid_terms');
    }
}
