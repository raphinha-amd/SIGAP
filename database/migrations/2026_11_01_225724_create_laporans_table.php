<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_laporan_id')->constrained()->onDelete('cascade');
            $table->string('judul_laporan');
            $table->text('deskripsi_laporan');
            $table->text('alamat');
            $table->enum('status_laporan', ['menunggu', 'verifikasi', 'proses', 'tolak', 'selesai'])->default('menunggu');
            $table->text('catatan_petugas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
