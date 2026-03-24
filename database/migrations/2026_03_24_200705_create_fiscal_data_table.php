<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fiscal_data', function (Blueprint $table) {
            $table->uuid('fiscal_id')->primary();
            $table->string('rfc');
            $table->string('legal_name');
            $table->string('tax_regime');
            $table->string('cfdi_use');
            $table->string('email_for_invoice');

            $table->uuid('customer_id')->unique();
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fiscal_data');
    }
};