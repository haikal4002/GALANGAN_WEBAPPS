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
        Schema::create('pos_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('no_trx')->unique(); // TRX-20260127-001
            $table->foreignId('user_id')->constrained('users'); // Kasir
            $table->decimal('total_amount', 15, 2);
            $table->decimal('bayar_amount', 15, 2); // Uang yang dibayarkan/diterima
            $table->decimal('kembalian', 15, 2);
            $table->string('payment_method'); // cash, qris, transfer
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_transactions');
    }
};
