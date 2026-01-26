<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ================================================================================
 * Migration 2: Tabel untuk multiple dokumen (BA, Surat Pernyataan, dll)
 *
 * File: database/migrations/2024_xx_xx_create_peminjaman_dokumen_table.php
 * ================================================================================
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')
                  ->constrained('peminjamans')
                  ->onDelete('cascade')
                  ->comment('ID peminjaman yang terkait');

            $table->string('dokumen_path')
                  ->comment('Path file dokumen di storage (REQUIRED)');

            $table->string('nama_dokumen')->nullable()
                  ->comment('Nama asli file dokumen (opsional)');

            $table->string('keterangan')->nullable()
                  ->comment('Keterangan/deskripsi dokumen (opsional)');

            $table->timestamps();

            // Index untuk performa query
            $table->index('peminjaman_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_dokumen');
    }
};

