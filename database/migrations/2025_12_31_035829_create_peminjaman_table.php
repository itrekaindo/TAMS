<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman')->unique();

            // Data Peminjam
            $table->string('nama_lengkap');
            $table->string('nip');
            $table->string('departemen');

            // Data Peminjaman
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            $table->string('nama_alat'); // Duplicate untuk history
            $table->string('kode_alat'); // Duplicate untuk history
            $table->integer('jumlah');
            $table->enum('kondisi_alat', ['baik', 'rusak_ringan', 'rusak_berat', 'maintenance']);
            $table->date('tanggal_pinjam');
            $table->text('keperluan');
            $table->string('foto_peminjaman')->nullable();

            // Data Pengembalian
            $table->date('tanggal_kembali_rencana');
            $table->date('tanggal_kembali_aktual')->nullable();
            $table->enum('kondisi_alat_kembali', ['baik', 'rusak_ringan', 'rusak_berat', 'maintenance'])->nullable();
            $table->string('foto_pengembalian')->nullable();
            $table->text('keterangan_pengembalian')->nullable();

            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjamans');
    }
};
