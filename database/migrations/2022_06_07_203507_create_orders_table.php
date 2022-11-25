<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('uuid')->primary()->unique();
            $table->longText('orderItems');
            $table->longText('shippingAddress');
            $table->double('total');
            $table->double('taxPrice');
            $table->double('totalPrice');
            $table->double('shippingPrice');
            $table->boolean('isPaid')->default(0);
            $table->boolean('isDelivered')->default(0);
            $table->string('paidAt')->nullable();
            $table->string('deliveredAt')->nullable();
            $table->string('paymentResult')->nullable();
            $table->enum('paymentMethod',['Cash','Paypal', 'Flutterwave']);
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
        Schema::dropIfExists('orders');
    }
}