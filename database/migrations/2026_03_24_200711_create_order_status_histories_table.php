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

            $table->uuid('order_id');
            $table->uuid('changed_by_user_id');

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('changed_by_user_id')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_status_histories');
    }
};