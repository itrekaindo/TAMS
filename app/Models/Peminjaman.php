<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'kode_peminjaman',
        'peminjam_id',
        'nama_lengkap',
        'nip',
        'departemen',
        'email',
        'telepon',
        'tanggal_pinjam',
        'keperluan',
        'foto_peminjaman',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'foto_pengembalian',
        'keterangan_pengembalian',
        'status'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
    ];


    // Relasi ke detail peminjaman (multiple items)
    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id');
    }

    // Relasi ke alat
    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    // Relasi ke peminjam (nullable karena bisa ada data lama tanpa peminjam_id)
    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'peminjam_id');
    }

    // Check apakah terlambat
    public function isLate()
    {
        if ($this->status === 'dipinjam') {
            return Carbon::now()->gt($this->tanggal_kembali_rencana);
        }
        return false;
    }

    // Kondisi options
    public static function kondisiOptions()
    {
        return [
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'maintenance' => 'Maintenance'
        ];
    }

    // Accessor untuk nama peminjam (backward compatibility)
    public function getNamaPeminjamAttribute()
    {
        // Jika ada relasi peminjam, gunakan dari sana
        if ($this->peminjam) {
            return $this->peminjam->nama_lengkap;
        }
        // Fallback ke kolom nama_lengkap
        return $this->nama_lengkap;
    }

    // Accessor untuk NIP peminjam (backward compatibility)
    public function getNipPeminjamAttribute()
    {
        if ($this->peminjam) {
            return $this->peminjam->nip;
        }
        return $this->nip;
    }

    // Accessor untuk departemen peminjam (backward compatibility)
    public function getDepartemenPeminjamAttribute()
    {
        if ($this->peminjam) {
            return $this->peminjam->departemen;
        }
        return $this->departemen;
    }

    // Accessor untuk total jumlah alat
    public function getTotalJumlahAttribute()
    {
        return $this->details->sum('jumlah');
    }

    // Accessor untuk total jenis alat
    public function getTotalJenisAlatAttribute()
    {
        return $this->details->count();
    }
}
