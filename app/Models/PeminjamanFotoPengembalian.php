<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * ================================================================================
 * Model: PeminjamanFotoPengembalian
 *
 * File: app/Models/PeminjamanFotoPengembalian.php
 *
 * Untuk menyimpan multiple foto pengembalian per peminjaman
 * ================================================================================
 */
class PeminjamanFotoPengembalian extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_foto_pengembalian';

    protected $fillable = [
        'peminjaman_id',
        'foto_path',
        'keterangan',
        'tanggal_upload'
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    /**
     * Relasi ke peminjaman (many-to-one)
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    /**
     * Accessor untuk mendapatkan full URL foto
     */
    public function getFotoUrlAttribute()
    {
        return $this->foto_path ? Storage::url($this->foto_path) : null;
    }

    /**
     * Accessor untuk cek apakah file foto ada
     */
    public function getFotoExistsAttribute()
    {
        return $this->foto_path && Storage::exists($this->foto_path);
    }

    /**
     * Method untuk delete foto dari storage
     */
    public function deleteFoto()
    {
        if ($this->foto_path && Storage::exists($this->foto_path)) {
            Storage::delete($this->foto_path);
        }
    }

    /**
     * Override delete untuk auto-delete file dari storage
     */
    public function delete()
    {
        $this->deleteFoto();
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
     * Scope untuk foto terbaru
     */
    public function scopeTerbaru($query)
    {
        return $query->orderBy('tanggal_upload', 'desc');
    }
}
