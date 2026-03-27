<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_delivery_addresses', function (Blueprint $table) {
            $table->uuid('order_address_id')->primary();

            $table->string('street');
            $table->string('ext_number');
            $table->string('int_number')->nullable();
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('references')->nullable();
            
            $table->foreignId('order_id')
                ->unique()
                ->constrained('orders')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_delivery_addresses');
    }
};