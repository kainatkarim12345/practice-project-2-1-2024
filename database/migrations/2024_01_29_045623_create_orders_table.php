<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('order_status', ['recieved', 'process', 'completed' ,'cancelled'])->default('recieved');
            $table->string('order_number')->unique();
            $table->string('billing_address');
            $table->string('shipping_address');
            $table->unsignedBigInteger('cart_product_id');
            $table->unsignedBigInteger('method_id');
            $table->unsignedBigInteger('city_id');


            $table->foreign('cart_product_id')->references('id')->on('cart_products')->onDelete('cascade');
            $table->foreign('method_id')->references('id')->on('methods')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
