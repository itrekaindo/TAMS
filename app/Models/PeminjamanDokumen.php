<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * ================================================================================
 * Model: PeminjamanDokumen
 *
 * File: app/Models/PeminjamanDokumen.php
 *
 * Untuk menyimpan multiple dokumen (BA, Surat Pernyataan, dll) per peminjaman
 * ================================================================================
 */
class PeminjamanDokumen extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_dokumen';

    protected $fillable = [
        'peminjaman_id',
        'dokumen_path',
        'nama_dokumen',
        'keterangan'
    ];

    /**
     * Relasi ke peminjaman (many-to-one)
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    /**
     * Accessor untuk mendapatkan full URL dokumen
     */
    public function getDokumenUrlAttribute()
    {
        return $this->dokumen_path ? Storage::url($this->dokumen_path) : null;
    }

    /**
     * Accessor untuk cek apakah file dokumen ada
     */
    public function getDokumenExistsAttribute()
    {
        return $this->dokumen_path && Storage::exists($this->dokumen_path);
    }

    /**
     * Accessor untuk mendapatkan nama file dari path
     */
    public function getNamaFileAttribute()
    {
        return $this->nama_dokumen ?: basename($this->dokumen_path);
    }

    /**
     * Accessor untuk mendapatkan ekstensi file
     */
    public function getEkstensiFileAttribute()
    {
        return pathinfo($this->dokumen_path, PATHINFO_EXTENSION);
    }

    /**
     * Accessor untuk cek apakah file adalah PDF
     */
    public function getIsPdfAttribute()
    {
        return strtolower($this->ekstensi_file) === 'pdf';
    }

    /**
     * Accessor untuk mendapatkan ukuran file (dalam bytes)
     */
    public function getUkuranFileAttribute()
    {
        if ($this->dokumen_path && Storage::exists($this->dokumen_path)) {
            return Storage::size($this->dokumen_path);
        }
        return 0;
    }

    /**
     * Accessor untuk mendapatkan ukuran file dalam format readable (KB, MB)
     */
    public function getUkuranFileReadableAttribute()
    {
        $bytes = $this->ukuran_file;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    /**
     * Method untuk delete dokumen dari storage
     */
    public function deleteDokumen()
    {
        if ($this->dokumen_path && Storage::exists($this->dokumen_path)) {
            Storage::delete($this->dokumen_path);
        }
    }

    /**
     * Override delete untuk auto-delete file dari storage
     */
    public function delete()
    {
        $this->deleteDokumen();
        return parent::delete();
    }

    /**
     * Scope untuk filter berdasarkan peminjaman
     */
    public function scopeByPeminjaman($query, $peminjamanId)
    {
        return $query->where('peminjaman_id', $peminjamanId);
    }

    /**
     * Scope untuk dokumen terbaru
     */
    public function scopeTerbaru($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
