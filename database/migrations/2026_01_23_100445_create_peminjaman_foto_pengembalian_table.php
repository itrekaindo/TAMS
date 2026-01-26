<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration 1: Tabel untuk multiple foto pengembalian
 *
 * File: database/migrations/2024_xx_xx_create_peminjaman_foto_pengembalian_table.php
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_foto_pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')
                  ->constrained('peminjamans')
                  ->onDelete('cascade')
                  ->comment('ID peminjaman yang terkait');

            $table->string('foto_path')
                  ->comment('Path file foto di storage');

            $table->string('keterangan')->nullable()
                  ->comment('Keterangan/deskripsi foto');

            $table->timestamp('tanggal_upload')
                  ->useCurrent()
                  ->comment('Tanggal foto diupload');

            $table->timestamps();

            // Index untuk performa query
            $table->index('peminjaman_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_foto_pengembalian');
    }
};
