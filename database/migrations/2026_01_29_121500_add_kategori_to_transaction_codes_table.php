<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaction_codes', function (Blueprint $table) {
            $table->enum('kategori', ['pemasukan', 'pengeluaran'])->default('pemasukan')->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('transaction_codes', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
