<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->string('customer_number');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('rfc')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            $table->string('state');
            $table->dateTime('date_time');
            $table->string('banner_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};