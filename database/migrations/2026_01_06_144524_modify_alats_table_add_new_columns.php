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
        Schema::table('alats', function (Blueprint $table) {
            // Ubah kolom yang sudah ada menjadi nullable (kecuali nama_alat)
            $table->string('kode_alat', 50)->nullable()->change();
            $table->text('deskripsi')->nullable()->change();
            $table->integer('jumlah_total')->nullable()->change();
            $table->integer('jumlah_tersedia')->nullable()->change();
            $table->string('kondisi', 50)->nullable()->change();
            $table->string('kategori', 100)->nullable()->change();
            $table->string('lokasi')->nullable()->change();

            // Tambah kolom baru sesuai screenshot
            $table->string('spesifikasi_type', 255)->nullable()->after('nama_alat');
            $table->string('merk', 100)->nullable()->after('spesifikasi_type');
            $table->integer('kapasitas')->nullable()->after('merk');
            $table->string('jenis_tools', 100)->nullable()->after('kondisi');
            $table->string('pic', 100)->nullable()->after('lokasi');
            $table->string('proyek', 100)->nullable()->after('pic');
            $table->string('kategori_tools', 100)->nullable()->after('proyek');
            $table->string('foto_tools')->nullable()->after('kategori_tools');
            $table->string('sticker', 50)->nullable()->after('foto_tools');
            $table->string('pemakai', 100)->nullable()->after('sticker');
            $table->string('lokasi_distribusi', 100)->nullable()->after('pemakai');
            $table->boolean('hilang')->default(false)->after('lokasi_distribusi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alats', function (Blueprint $table) {
            // Kembalikan kolom yang diubah
            $table->string('kode_alat', 50)->nullable(false)->change();
            $table->text('deskripsi')->nullable(false)->change();
            $table->integer('jumlah_total')->nullable(false)->change();
            $table->integer('jumlah_tersedia')->nullable(false)->change();
            $table->string('kondisi', 50)->nullable(false)->change();
            $table->string('kategori', 100)->nullable(false)->change();
            $table->string('lokasi')->nullable(false)->change();

            // Hapus kolom baru
            $table->dropColumn([
                'spesifikasi_type',
                'merk',
                'kapasitas',
                'jenis_tools',
                'pic',
                'proyek',
                'kategori_tools',
                'foto_tools',
                'sticker',
                'pemakai',
                'lokasi_distribusi',
                'hilang'
            ]);
        });
    }
};
