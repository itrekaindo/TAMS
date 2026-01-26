<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update tabel peminjaman_details
        Schema::table('peminjaman_detail', function (Blueprint $table) {
            // Kolom untuk tracking jumlah yang sudah dikembalikan
            $table->integer('jumlah_dikembalikan')->default(0)->after('jumlah');

            // Status per item
            $table->enum('status_item', [
                'dipinjam',
                'sebagian_dikembalikan',
                'dikembalikan'
            ])->default('dipinjam')->after('keterangan');

            // Timestamp kapan item ini dikembalikan penuh
            $table->timestamp('tanggal_kembali_item')->nullable()->after('status_item');
        });

        // 2. Update enum status di tabel peminjamans
        DB::statement("
            ALTER TABLE peminjamans
            MODIFY COLUMN status ENUM(
                'dipinjam',
                'sebagian_dikembalikan',
                'dikembalikan',
                'terlambat'
            ) DEFAULT 'dipinjam'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman_detail', function (Blueprint $table) {
            $table->dropColumn([
                'jumlah_dikembalikan',
                'status_item',
                'tanggal_kembali_item'
            ]);
        });

        DB::statement("
            ALTER TABLE peminjamans
            MODIFY COLUMN status ENUM(
                'dipinjam',
                'dikembalikan',
                'terlambat'
            ) DEFAULT 'dipinjam'
        ");
    }
};
