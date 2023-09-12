<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Payments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('student_uuid')->references('uuid')->on('students')->onDelete('cascade');
            $table->string('paid_by')->nullable();
            $table->double('initial')->nullable();
            $table->double('payable')->nullable();
            $table->double('amount');
            $table->double('balance')->nullable();
            $table->enum('payment_category', ['ecommerce', 'schoolbus_service', 'school_fees'])->default('school_fees');
            $table->enum('payment_type', ['partial', 'full'])->default('full');
            $table->foreignId('period_id')->constrained('periods')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->string('channel')->nullable();
            $table->string('trans_id')->nullable();
            $table->string('ref_id')->nullable();
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
        Schema::dropIfExists('payments');
    }
}