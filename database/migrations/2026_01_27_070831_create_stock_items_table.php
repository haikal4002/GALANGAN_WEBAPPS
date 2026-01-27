<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nomor_resi')->nullable();
            $table->foreignId('master_product_id')->constrained('master_products');
            $table->integer('qty');
            $table->integer('qty_kulak');
            $table->integer('stok_awal');
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('nominal', 15, 2);
            $table->integer('margin')->default(0);
            $table->decimal('harga_jual', 15, 2);
            $table->decimal('harga_atas', 15, 2)->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->string('status_pembayaran')->default('Lunas');
            $table->string('status_barang')->default('Diterima');
            $table->date('jatuh_tempo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_items');
    }
};
