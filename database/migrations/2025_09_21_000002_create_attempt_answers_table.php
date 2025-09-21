<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attempt_answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('attempt_id')->index();
            $table->unsignedBigInteger('question_id')->index();
            $table->unsignedTinyInteger('answer_index')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->json('question_snapshot')->nullable();
            $table->timestamps();

            $table->foreign('attempt_id')->references('id')->on('assessment_attempts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attempt_answers');
    }
};
