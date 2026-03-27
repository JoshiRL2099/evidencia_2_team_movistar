<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('order_status_histories', function (Blueprint $table) {
            $table->uuid('history_id')->primary();

            $table->string('from_status');
            $table->string('to_status');
            $table->timestamp('changed_at')->useCurrent();
            $table->string('comment')->nullable();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->onDelete('cascade');

            $table->foreignId('changed_by_user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
    }
};