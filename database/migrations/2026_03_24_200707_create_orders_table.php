<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('order_id')->primary();
            $table->string('invoice_number');
            $table->timestamp('order_datetime');
            $table->text('notes')->nullable();
            $table->enum('status', ['ORDERED', 'IN_PROCESS', 'IN_ROUTE', 'DELIVERED', 'DELETED']);
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->uuid('customer_id');
            $table->uuid('created_by_user_id');

            $table->foreign('customer_id')->references('customer_id')->on('customers');
            $table->foreign('created_by_user_id')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};