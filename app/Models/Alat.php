<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alats';

    protected $fillable = [
        'kode_alat',
        'nama_alat',
        'deskripsi',
        'jumlah_total',
        'jumlah_tersedia',
        'kondisi',
        'kategori',
        'lokasi',
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
        'hilang',
    ];

    // public function peminjamans()
    // {
    //     return $this->hasMany(Peminjaman::class);
    // }

    protected $casts = [
        'sticker' => 'boolean',
        'hilang' => 'boolean',
        'jumlah_total' => 'integer',
        'jumlah_tersedia' => 'integer',
    ];

    public function peminjamanDetails()
    {
        return $this->hasMany(PeminjamanDetail::class);
    }

    public function peminjamans()
    {
        return $this->hasManyThrough(
            Peminjaman::class,
            PeminjamanDetail::class,
            'alat_id',
            'id',
            'id',
            'peminjaman_id'
        );
    }

    public static function kondisiOptions()
    {
        return [
            'baik' => 'Baik',
            'rusak' => 'Rusak',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'maintenance' => 'Maintenance',
        ];
    }

    public static function jenisToolsOptions()
    {
        return [
            'Measuring Tools' => 'Measuring Tools',
            'Hand Tools' => 'Hand Tools',
            'Special Tools' => 'Special Tools',
            'Power Tools' => 'Power Tools',
            'Cutting Tools' => 'Cutting Tools',
            'Lifting Tools' => 'Lifting Tools',
            'Safety Tools' => 'Safety Tools',
        ];
    }

    public static function kategoriToolsOptions()
    {
        return [
            'Tools' => 'Tools',
            'Mesin' => 'Mesin',
        ];
    }

    public static function proyekOptions()
    {
        return [
            'Stanby' => 'Stanby',
            'All Proyek' => 'All Proyek',
            '612' => '612',
            'Harness 612' => 'Harness 612',
            'Koneksi & Assy KCI' => 'Koneksi & Assy KCI',
            'Koneksi & Revisi KCI' => 'Koneksi & Revisi KCI',
            'Maintenance' => 'Maintenance',
            'Panel 612' => 'Panel 612',
            'Panel KCI' => 'Panel KCI',
            'RTI RTO 612' => 'RTI RTO 612',
        ];
    }


}
