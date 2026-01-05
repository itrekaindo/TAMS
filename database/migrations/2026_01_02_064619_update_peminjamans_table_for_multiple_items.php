<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('peminjamans', function (Blueprint $table) {

            $table->dropForeign(['alat_id']);
            // Hapus kolom yang sudah pindah ke detail
            $table->dropColumn([
                'alat_id',
                'nama_alat',
                'kode_alat',
                'jumlah',
                'kondisi_alat',
                'kondisi_alat_kembali'
            ]);
        });
    }

    public function down()
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->foreignId('alat_id')->constrained('alats');
            $table->string('nama_alat');
            $table->string('kode_alat');
            $table->integer('jumlah');
            $table->enum('kondisi_alat', ['baik', 'rusak_ringan', 'rusak_berat', 'maintenance']);
            $table->enum('kondisi_alat_kembali', ['baik', 'rusak_ringan', 'rusak_berat', 'maintenance'])->nullable();
        });
    }
};
