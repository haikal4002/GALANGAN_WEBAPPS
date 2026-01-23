<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases')->onDelete('cascade');

            // Barang apa yang dibeli (mengacu ke satuan spesifik, misal beli Lem "Dos")
            $table->foreignId('product_unit_id')->constrained('product_units');

            $table->integer('qty'); // Jumlah yang dibeli
            $table->decimal('harga_beli_satuan', 15, 2); // Harga beli SAAT ITU (bisa beda dgn skrg)
            $table->decimal('subtotal', 15, 2); // qty * harga_beli_satuan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};