<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
    $table->id();

    $table->enum('type', ['LOADED_UNIT', 'UNLOADED_EVIDENCE']);
    $table->string('url');
    $table->timestamp('uploaded_at')->useCurrent();

    $table->foreignId('order_id')
          ->constrained('orders')
          ->onDelete('cascade');

    $table->foreignId('uploaded_by_user_id')
          ->constrained('users')
          ->onDelete('cascade');

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};