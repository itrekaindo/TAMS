<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alat')->unique();
            $table->string('nama_alat');
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah_total');
            $table->integer('jumlah_tersedia');
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat', 'maintenance'])->default('baik');
            $table->string('kategori')->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alats');
    }
};
