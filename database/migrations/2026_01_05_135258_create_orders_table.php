<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->foreignId('vendor_id')->constrained();
        $table->string('nomor_antrean'); // Contoh: A-001
        $table->integer('total_harga');
        $table->enum('status', ['menunggu', 'dimasak', 'siap', 'selesai', 'dibatalkan'])->default('menunggu');
        $table->integer('estimasi_menit')->default(15);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
