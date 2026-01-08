<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kita menambah kolom balance (saldo)
            // decimal(12,2) artinya bisa menyimpan sampai ratusan miliar dengan 2 angka di belakang koma
            $table->decimal('balance', 12, 2)->default(0)->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ini untuk membatalkan jika nanti kamu melakukan migrate:rollback
            $table->dropColumn('balance');
        });
    }
};