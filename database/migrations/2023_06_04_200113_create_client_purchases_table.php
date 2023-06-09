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
        Schema::create('client_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->onDelete('cascade');
            $table->unsignedBigInteger('seller_id')->onDelete('cascade');

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('seller_id')->references('id')->on('sellers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_purchases');
    }
};
