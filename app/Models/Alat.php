<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'deskripsi',
        'jumlah_total',
        'jumlah_tersedia',
        'kondisi',
        'kategori',
        'lokasi'
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function peminjamanDetails()
    {
        return $this->hasMany(\App\Models\PeminjamanDetail::class, 'alat_id');
    }

    public static function kondisiOptions()
    {
        return [
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'maintenance' => 'Maintenance'
        ];
    }
}
