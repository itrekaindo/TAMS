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
        Schema::table('peminjamans', function (Blueprint $table) {
            // Tambah kolom peminjam_id setelah kode_peminjaman
            $table->foreignId('peminjam_id')
                  ->nullable()
                  ->after('kode_peminjaman')
                  ->constrained('peminjam')
                  ->onDelete('cascade');

            // Tambah kolom email dan telepon jika belum ada
            if (!Schema::hasColumn('peminjamans', 'email')) {
                $table->string('email')->nullable()->after('departemen');
            }

            if (!Schema::hasColumn('peminjamans', 'telepon')) {
                $table->string('telepon', 20)->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['peminjam_id']);
            $table->dropColumn('peminjam_id');

            if (Schema::hasColumn('peminjamans', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('peminjamans', 'telepon')) {
                $table->dropColumn('telepon');
            }
        });
    }
};
