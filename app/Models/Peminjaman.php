<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\PeminjamanFotoPengembalian;
use App\Models\PeminjamanDokumen;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjaman extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'surat_pernyataan',
        'keterangan_pengembalian',
        'status'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali_rencana' => 'datetime',
        'tanggal_kembali_aktual' => 'datetime',
    ];

    // Relasi ke detail peminjaman (multiple items)
    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_id');
    }

    // Relasi ke peminjam (nullable karena bisa ada data lama tanpa peminjam_id)
    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'peminjam_id');
    }

    // ✅ TAMBAHKAN INI
    public function fotoPengembalian()
    {
        return $this->hasMany(PeminjamanFotoPengembalian::class, 'peminjaman_id');
    }

    public function dokumen()
    {
        return $this->hasMany(PeminjamanDokumen::class, 'peminjaman_id');
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
        if ($this->peminjam) {
            return $this->peminjam->nama_lengkap;
        }
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

    /**
     * Cek apakah peminjaman bisa diperpanjang
     */
    public function canBeExtended()
    {
        return $this->status === 'dipinjam';
    }

    /**
     * Get total berapa kali sudah di-extend (jika pakai tabel histori)
     */
    public function getExtendCount()
    {
        return 0; // Default jika belum ada tabel
    }

    /**
     * ✅ PERBAIKAN: Check apakah SEMUA item sudah dikembalikan
     * Bug: menggunakan every() yang tidak akan bekerja jika collection kosong
     */
    public function isFullyReturned()
    {
        // Pastikan ada details
        if ($this->details->isEmpty()) {
            return false;
        }

        // Cek apakah SEMUA detail sudah dikembalikan penuh
        return $this->details->every(function ($detail) {
            return $detail->jumlah_dikembalikan >= $detail->jumlah;
        });
    }

    /**
     * ✅ PERBAIKAN: Check apakah ada item yang sudah dikembalikan sebagian
     * Bug: menggunakan some() yang tidak ada di Laravel Collection, seharusnya contains()
     */
    public function hasPartialReturns()
    {
        return $this->details->contains(function ($detail) {
            return $detail->jumlah_dikembalikan > 0 && $detail->jumlah_dikembalikan < $detail->jumlah;
        });
    }

    /**
     * ✅ PERBAIKAN: Check apakah ada item yang sudah dikembalikan (sebagian/penuh)
     * Bug: menggunakan some() yang tidak ada di Laravel Collection
     */
    public function hasAnyReturns()
    {
        return $this->details->contains(function ($detail) {
            return $detail->jumlah_dikembalikan > 0;
        });
    }

    /**
     * ✅ PERBAIKAN: Get total item yang belum dikembalikan
     * Bug: accessor memanggil accessor lain yang tidak didefinisikan
     */
    public function getTotalItemBelumKembaliAttribute()
    {
        return $this->details->sum(function ($detail) {
            return $detail->jumlah - $detail->jumlah_dikembalikan;
        });
    }

    /**
     * Get total item yang sudah dikembalikan
     */
    public function getTotalItemDikembalikanAttribute()
    {
        return $this->details->sum('jumlah_dikembalikan');
    }

    /**
     * Get persentase pengembalian keseluruhan
     */
    public function getPersentasePengembalianAttribute()
    {
        $totalPinjam = $this->details->sum('jumlah');
        if ($totalPinjam == 0) return 0;

        $totalKembali = $this->details->sum('jumlah_dikembalikan');
        return round(($totalKembali / $totalPinjam) * 100, 2);
    }

    /**
     * ✅ PERBAIKAN UTAMA: Update status peminjaman berdasarkan status items
     *
     * Bug yang diperbaiki:
     * 1. Typo 'sebagian_dikembalikan' seharusnya 'dikembalikan_sebagian'
     * 2. Logika tidak memperhitungkan semua skenario dengan benar
     * 3. some() tidak ada di Laravel Collection
     */
    public function updateStatusBasedOnReturns()
    {
        // Refresh relasi untuk mendapatkan data terbaru
        $this->load('details');

        // Pastikan ada details
        if ($this->details->isEmpty()) {
            $this->status = 'dipinjam';
            $this->save();
            return;
        }

        // Cek apakah SEMUA item sudah dikembalikan PENUH
        $semuaDikembalikan = $this->details->every(function ($detail) {
            return $detail->jumlah_dikembalikan >= $detail->jumlah;
        });

        if ($semuaDikembalikan) {
            // ✅ SEMUA item sudah dikembalikan penuh
            $this->status = 'dikembalikan';

            // Set tanggal kembali aktual jika belum ada
            if (!$this->tanggal_kembali_aktual) {
                $this->tanggal_kembali_aktual = now();
            }
        } else {
            // Cek apakah ada yang sudah dikembalikan (sebagian atau penuh)
            $adaYangDikembalikan = $this->details->contains(function ($detail) {
                return $detail->jumlah_dikembalikan > 0;
            });

            if ($adaYangDikembalikan) {
                // ✅ Ada item yang sudah dikembalikan, tapi belum semua
                // PERBAIKAN: Typo 'sebagian_dikembalikan' → 'dikembalikan_sebagian'
                $this->status = 'sebagian_dikembalikan';
            } else {
                // ✅ Belum ada yang dikembalikan sama sekali
                $this->status = 'dipinjam';
            }
        }

        $this->save();
    }

    /**
     * Scope untuk filter peminjaman yang masih aktif (dipinjam/sebagian dikembalikan)
     */
    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['dipinjam', 'sebagian_dikembalikan']);
    }

    /**
     * Scope untuk filter peminjaman yang sudah selesai
     */
    public function scopeSelesai($query)
    {
        return $query->where('status', 'dikembalikan');
    }
}
