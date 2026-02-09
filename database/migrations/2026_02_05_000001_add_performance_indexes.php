<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add indexes for frequently queried columns
        Schema::table('product_units', function (Blueprint $table) {
            $table->index('stok'); // For filtering low stock
            $table->index('updated_at'); // For ordering by recent updates
            $table->index(['master_product_id', 'master_unit_id']); // For checking duplicates
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->index('status_pembayaran'); // For filtering unpaid purchases
            $table->index('tanggal'); // For ordering by date
            $table->index(['tanggal', 'status_pembayaran']); // Composite for common queries
        });

        Schema::table('purchase_details', function (Blueprint $table) {
            $table->index('purchase_id'); // Already exists via FK, but ensuring
            $table->index('product_unit_id'); // Already exists via FK, but ensuring
        });

        Schema::table('master_products', function (Blueprint $table) {
            $table->index('nama'); // For searching/ordering by name
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->index('nama'); // For searching/ordering by name
        });

        Schema::table('master_units', function (Blueprint $table) {
            $table->index('nama'); // For searching/ordering by name
        });
    }

    public function down(): void
    {
        Schema::table('product_units', function (Blueprint $table) {
            $table->dropIndex(['stok']);
            $table->dropIndex(['updated_at']);
            $table->dropIndex(['master_product_id', 'master_unit_id']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropIndex(['status_pembayaran']);
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['tanggal', 'status_pembayaran']);
        });

        Schema::table('master_products', function (Blueprint $table) {
            $table->dropIndex(['nama']);
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropIndex(['nama']);
        });

        Schema::table('master_units', function (Blueprint $table) {
            $table->dropIndex(['nama']);
        });
    }
};
