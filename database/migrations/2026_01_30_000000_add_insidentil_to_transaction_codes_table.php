<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transaction_codes', function (Blueprint $table) {
            $table->boolean('insidentil')->default(false)->after('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('transaction_codes', function (Blueprint $table) {
            $table->dropColumn('insidentil');
        });
    }
};
