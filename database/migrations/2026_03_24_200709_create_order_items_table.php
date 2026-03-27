<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('order_item_id')->primary();

            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 10, 2)->nullable();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->constrained('products');

            $table->unique(['order_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};