<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peminjaman_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            $table->string('nama_alat');
            $table->string('kode_alat');
            $table->integer('jumlah');
            $table->enum('kondisi_alat', ['baik', 'rusak_ringan', 'rusak_berat', 'maintenance']);
            $table->enum('kondisi_alat_kembali', ['baik', 'rusak_ringan', 'rusak_berat', 'maintenance'])->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman_detail');
    }
};
