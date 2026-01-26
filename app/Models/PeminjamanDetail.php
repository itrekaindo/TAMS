<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_detail';

    protected $fillable = [
        'peminjaman_id',
        'alat_id',
        'nama_alat',
        'kode_alat',
        'jumlah',
        'jumlah_dikembalikan',
        'status_item',
        'tanggal_kembali_item',
        'kondisi_alat',
        'kondisi_alat_kembali',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_kembali_item' => 'datetime'
    ];

    // relasi ke Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // relasi ke Alat
    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    /**
     * Accessor: Jumlah yang belum dikembalikan
     */
    public function getJumlahBelumKembaliAttribute()
    {
        return $this->jumlah - $this->jumlah_dikembalikan;
    }

    /**
     * Check apakah item ini sudah dikembalikan semua
     */
    public function isFullyReturned()
    {
        return $this->jumlah_dikembalikan >= $this->jumlah;
    }

    /**
     * Check apakah sebagian sudah dikembalikan
     */
    public function isPartiallyReturned()
    {
        return $this->jumlah_dikembalikan > 0 && $this->jumlah_dikembalikan < $this->jumlah;
    }

    /**
     * Check apakah item belum dikembalikan sama sekali
     */
    public function isNotReturned()
    {
        return $this->jumlah_dikembalikan == 0;
    }

    /**
     * Get persentase pengembalian
     */
    public function getPersentasePengembalianAttribute()
    {
        if ($this->jumlah == 0) return 0;
        return round(($this->jumlah_dikembalikan / $this->jumlah) * 100, 2);
    }

    /**
     * Get label status untuk ditampilkan
     */
    public function getStatusLabelAttribute()
    {
        if ($this->isFullyReturned()) {
            return 'Sudah Dikembalikan';
        } elseif ($this->isPartiallyReturned()) {
            return "Dikembalikan {$this->jumlah_dikembalikan}/{$this->jumlah}";
        } else {
            return 'Belum Dikembalikan';
        }
    }

    /**
     * Get badge class untuk status
     */
    public function getStatusBadgeClassAttribute()
    {
        if ($this->isFullyReturned()) {
            return 'bg-success'; // hijau
        } elseif ($this->isPartiallyReturned()) {
            return 'bg-warning'; // kuning
        } else {
            return 'bg-danger'; // merah
        }
    }
}
