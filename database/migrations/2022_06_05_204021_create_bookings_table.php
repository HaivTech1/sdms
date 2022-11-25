<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('uuid')->unique();
            $table->longText('bookingItems');
            $table->longText('amenities')->nullable();
            $table->longText('furnish')->nullable();
            $table->double('totalPrice')->nullable();
            $table->boolean('isPaid')->default(0);
            $table->string('paidAt')->nullable();
            $table->enum('paymentMethod',['Cash','Paypal', 'Flutter'])->nullable();
            $table->string('paymentResult')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}