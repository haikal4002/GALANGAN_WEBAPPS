<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('master_units', function (Blueprint $table) {
            $table->enum('kategori', ['pemasukan', 'pengeluaran'])->default('pemasukan')->after('singkatan');
        });
    }

    public function down(): void
    {
        Schema::table('master_units', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
