<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales_logs', function (Blueprint $table) {
            $table->id();
            // Ubah relasi ke product_units
            $table->foreignId('product_unit_id')->constrained('product_units');

            $table->date('tanggal_jual');
            $table->integer('qty_terjual');
            $table->decimal('harga_satuan', 15, 2); // Harga saat terjual
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_logs');
    }
};