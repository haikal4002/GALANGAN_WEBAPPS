<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_units', function (Blueprint $table) {
            $table->id();
            // Relasi ke Master Product
            $table->foreignId('master_product_id')->constrained('master_products')->onDelete('cascade');
            
            $table->string('satuan'); // Contoh: "Sak", "Kg", "Dos", "Pcs"
            $table->integer('nilai_konversi')->default(1); // 1 untuk satuan terkecil. Misal 1 Dos = 12 Pcs
            $table->boolean('is_base_unit')->default(false); // Penanda apakah ini satuan dasar
            
            // Data Stok Aktif
            $table->integer('stok')->default(0);
            
            // Harga
            $table->decimal('harga_beli_terakhir', 15, 2)->default(0); // HPP Terakhir
            $table->decimal('margin', 5, 2)->default(0); // Persentase Margin
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->decimal('harga_atas', 15, 2)->default(0); // Limit harga atas (opsional)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_units');
    }
};