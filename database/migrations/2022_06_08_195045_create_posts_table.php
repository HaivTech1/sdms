<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->unique();
            $table->string('title');
            $table->text('description');
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->timestamp('published_at');
            $table->enum('type', ['standard', 'premium'])->default('standard');
            $table->enum('badge', ['popular', 'regular'])->default('regular');
            $table->boolean('is_commentable')->default(1);
            $table->string('photo_credit_text')->nullable();
            $table->string('photo_credit_link')->nullable();
            $table->boolean('isAvailable')->default(0);
            $table->boolean('isVerified')->default(0);
            $table->foreignId('post_category_id')->nullable()->constrained('post_categories')->onDelete('set null');
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
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
        Schema::dropIfExists('posts');
    }
}