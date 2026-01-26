<?php

namespace App\Services;

use App\Models\Alat;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlatImportService
{
    private $successCount = 0;
    private $failedCount = 0;
    private $errors = [];

    public function import($filePath)
    {
        try {
            Log::info('Import started', [
                'file_path' => $filePath,
                'file_exists' => file_exists($filePath),
                'is_readable' => is_readable($filePath)
            ]);

            if (!file_exists($filePath)) {
                throw new \Exception("File tidak ditemukan: {$filePath}");
            }

            if (!is_readable($filePath)) {
                throw new \Exception("File tidak bisa dibaca: {$filePath}");
            }

            // Load file Excel
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Ambil header (baris pertama)
            $header = array_shift($rows);

            // Mapping header ke index (case-insensitive)
            $headerMap = [];
            foreach ($header as $index => $col) {
                $headerMap[strtolower(trim(str_replace([' ', '.', '-'], ['_', '', '_'], $col)))] = $index;
            }

            Log::info('Header mapping', ['headers' => $headerMap]);

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                // Skip baris kosong
                if (empty(array_filter($row))) {
                    continue;
                }

                try {
                    $this->processRow($row, $headerMap, $index + 2);
                } catch (\Exception $e) {
                    $this->failedCount++;
                    $this->errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                    Log::error("Row {$index} error", ['error' => $e->getMessage()]);
                }
            }

            DB::commit();

            return [
                'success' => true,
                'successCount' => $this->successCount,
                'failedCount' => $this->failedCount,
                'errors' => $this->errors
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Import error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function processRow($row, $headerMap, $rowNumber)
    {
        // Ambil nama_alat (wajib)
        $namaAlat = $this->getValueByHeader($row, $headerMap, 'nama_alat');

        // Validasi nama_alat wajib ada
        if (empty($namaAlat)) {
            throw new \Exception("Nama alat wajib diisi");
        }

        // Ambil dan validasi kondisi
        $kondisi = $this->getValueByHeader($row, $headerMap, 'kondisi');

        // Normalize kondisi (case-insensitive)
        if ($kondisi) {
            $kondisiLower = strtolower($kondisi);
            $validKondisi = ['baik', 'rusak', 'rusak_ringan', 'rusak_berat', 'maintenance'];

            // Cek apakah kondisi valid
            if (!in_array($kondisiLower, $validKondisi)) {
                // Jika tidak valid, set default
                $kondisi = 'baik';
            } else {
                $kondisi = $kondisiLower;
            }
        } else {
            $kondisi = 'baik';
        }

        // Data yang akan disimpan (semua nullable kecuali nama_alat)
        $data = [
            'nama_alat' => $namaAlat,
            'kode_alat' => $this->getValueByHeader($row, $headerMap, 'kode_alat'),
            'spesifikasi_type' => $this->getValueByHeader($row, $headerMap, 'spesifikasi_type'),
            'merk' => $this->getValueByHeader($row, $headerMap, 'merk'),
            'kapasitas' => $this->getValueByHeader($row, $headerMap, 'kapasitas'),
            'deskripsi' => $this->getValueByHeader($row, $headerMap, 'deskripsi'),
            'jumlah_total' => $this->parseInteger($this->getValueByHeader($row, $headerMap, 'jumlah')),
            'jumlah_tersedia' => null, // Akan diset nanti
            'kondisi' => $kondisi,
            'kategori' => $this->getValueByHeader($row, $headerMap, 'kategori'),
            'lokasi' => $this->getValueByHeader($row, $headerMap, 'lokasi'),
            'pic' => $this->getValueByHeader($row, $headerMap, 'pic'),
            'proyek' => $this->getValueByHeader($row, $headerMap, 'proyek'),
            'kategori_tools' => $this->getValueByHeader($row, $headerMap, 'kategori_tools'),
            'pemakai' => $this->getValueByHeader($row, $headerMap, 'pemakai'),
            'lokasi_distribusi' => $this->getValueByHeader($row, $headerMap, 'lokasi_distribusi'),
            'hilang' => $this->parseBoolean($this->getValueByHeader($row, $headerMap, 'hilang')),
            'deskripsi' => $this->getValueByHeader($row, $headerMap, 'deskripsi'),
            'kategori' => $this->getValueByHeader($row, $headerMap, 'kategori'),
            'sticker' => $this->getValueByHeader($row, $headerMap, 'sticker'),
        ];

        // Set jumlah_tersedia = jumlah_total jika tidak diisi
        $data['jumlah_tersedia'] = $data['jumlah_total'] ?? 0;

        // Cek apakah data sudah ada berdasarkan kode_alat atau nama_alat
        $existingAlat = null;

        if (!empty($data['kode_alat'])) {
            $existingAlat = Alat::where('kode_alat', $data['kode_alat'])->first();
        }

        if (!$existingAlat) {
            $existingAlat = Alat::where('nama_alat', $data['nama_alat'])->first();
        }

        if ($existingAlat) {
            // Update
            $existingAlat->update($data);
            Log::info("Updated alat", ['id' => $existingAlat->id, 'nama' => $data['nama_alat']]);
        } else {
            // Insert
            Alat::create($data);
            Log::info("Created new alat", ['nama' => $data['nama_alat']]);
        }

        $this->successCount++;
    }

    /**
     * Ambil nilai dari row berdasarkan header
     */
    private function getValueByHeader($row, $headerMap, $columnName)
    {
        // Normalize column name
        $normalizedName = strtolower(str_replace([' ', '.', '-'], ['_', '', '_'], $columnName));

        // Coba berbagai variasi nama kolom
        $variations = [
            $normalizedName,
            str_replace('_', '', $normalizedName),
            $columnName,
            strtolower($columnName),
        ];

        foreach ($variations as $variant) {
            $index = $headerMap[$variant] ?? null;
            if ($index !== null && isset($row[$index])) {
                $value = trim($row[$index]);
                return ($value === '' || $value === null) ? null : $value;
            }
        }

        return null;
    }

    /**
     * Parse string ke integer
     */
    private function parseInteger($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Hapus karakter non-numeric kecuali minus
        $cleaned = preg_replace('/[^0-9-]/', '', $value);

        if ($cleaned === '' || $cleaned === '-') {
            return null;
        }

        return (int) $cleaned;
    }

    /**
     * Parse string ke boolean
     */
    private function parseBoolean($value)
    {
        if ($value === null || $value === '') {
            return false;
        }

        // Normalize value
        $value = strtolower(trim($value));

        // Check for truthy values
        $truthyValues = ['true', '1', 'yes', 'ya', 'y'];

        return in_array($value, $truthyValues);
    }

    /**
     * Get success count
     */
    public function getSuccessCount()
    {
        return $this->successCount;
    }

    /**
     * Get failed count
     */
    public function getFailedCount()
    {
        return $this->failedCount;
    }

    /**
     * Get errors
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
