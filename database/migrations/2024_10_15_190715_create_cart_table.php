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
      Schema::create('cart', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('order_id');
        $table->string('sku');
        $table->string('item_name');
        $table->string('item_parts');
        $table->string('item_parts_quantity');
        $table->string('item_part_prices');
        $table->decimal('grand_total', 10, 2);
        $table->timestamps();
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
