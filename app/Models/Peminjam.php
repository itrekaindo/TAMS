<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    use HasFactory;

    protected $table = 'peminjam'; // atau 'peminjams' sesuai nama tabel Anda

    protected $fillable = [
        'nama_lengkap',
        'nip',
        'departemen',
        'email',
        'telepon'
    ];

    // Relasi ke peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'peminjam_id');
    }

    // Accessor untuk format telepon
    public function getTeleponFormatAttribute()
    {
        if (!$this->telepon) return '-';

        // Format: 0812-3456-7890
        $telepon = preg_replace('/[^0-9]/', '', $this->telepon);
        if (strlen($telepon) >= 10) {
            return substr($telepon, 0, 4) . '-' . substr($telepon, 4, 4) . '-' . substr($telepon, 8);
        }
        return $this->telepon;
    }

    // Scope untuk searching
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nama_lengkap', 'like', "%{$search}%")
              ->orWhere('nip', 'like', "%{$search}%")
              ->orWhere('departemen', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }
}
