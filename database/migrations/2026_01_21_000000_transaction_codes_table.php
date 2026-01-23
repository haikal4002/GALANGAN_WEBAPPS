<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Contoh: IN-SALES, OUT-PURCHASE
            $table->string('label'); // Contoh: Penjualan, Pembelian Stok
            $table->string('color')->default('primary'); // Untuk badge warna di UI
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_codes');
    }
};