<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('attempt_answers')) {
            Schema::table('attempt_answers', function (Blueprint $table) {
                // make is_correct nullable (some DB drivers require drop/re-add; Laravel handles it)
                $table->boolean('is_correct')->nullable()->change();
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('attempt_answers')) {
            Schema::table('attempt_answers', function (Blueprint $table) {
                $table->boolean('is_correct')->default(false)->change();
            });
        }
    }
};
