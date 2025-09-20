<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curriculum_id')->nullable();
            $table->unsignedBigInteger('topic_id')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->text('question');
            $table->json('options')->nullable();
            $table->integer('correct_index')->default(0);
            $table->string('difficulty')->nullable();
            $table->string('bloom_level')->nullable();
            $table->text('explanation')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index('topic_id');
            $table->index('curriculum_id');
            $table->index('author_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
