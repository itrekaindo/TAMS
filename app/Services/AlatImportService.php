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
                if (empty(array_filter($row, fn($cell) => $cell !== null && trim($cell) !== ''))) {
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

        // Ambil dan normalisasi kondisi
        $kondisi = $this->getValueByHeader($row, $headerMap, 'kondisi');
        $validKondisi = ['baik', 'rusak', 'rusak_ringan', 'rusak_berat', 'maintenance'];

        if ($kondisi) {
            $kondisiLower = strtolower(trim($kondisi));
            $kondisi = in_array($kondisiLower, $validKondisi) ? $kondisiLower : 'baik';
        } else {
            $kondisi = 'baik';
        }

        // Ambil jumlah_total dari kolom 'jumlah' di Excel
        $jumlahTotal = $this->parseInteger($this->getValueByHeader($row, $headerMap, 'jumlah'));
        if ($jumlahTotal === null || $jumlahTotal < 1) {
            $jumlahTotal = 1; // Set default minimal 1
        }

        // Data yang akan disimpan — semua sesuai $fillable di model
        $data = [
            'nama_alat' => $namaAlat,
            'kode_alat' => $this->getValueByHeader($row, $headerMap, 'kode_alat'),
            'spesifikasi_type' => $this->getValueByHeader($row, $headerMap, 'spesifikasi_type'),
            'merk' => $this->getValueByHeader($row, $headerMap, 'merk'),
            'kapasitas' => $this->getValueByHeader($row, $headerMap, 'kapasitas'),
            'jenis_tools' => $this->getValueByHeader($row, $headerMap, 'jenis_tools'),
            'deskripsi' => $this->getValueByHeader($row, $headerMap, 'deskripsi'),
            'jumlah_total' => $jumlahTotal,
            'jumlah_tersedia' => $jumlahTotal, // = jumlah_total saat insert
            'kondisi' => $kondisi,
            'kategori' => $this->getValueByHeader($row, $headerMap, 'kategori'),
            'lokasi' => $this->getValueByHeader($row, $headerMap, 'lokasi'),
            'pic' => $this->getValueByHeader($row, $headerMap, 'pic'),
            'proyek' => $this->getValueByHeader($row, $headerMap, 'proyek'),
            'kategori_tools' => $this->getValueByHeader($row, $headerMap, 'kategori_tools'),
            'foto_tools' => $this->getValueByHeader($row, $headerMap, 'foto_tools'),
            'sticker' => $this->getValueByHeader($row, $headerMap, 'sticker'),
            'pemakai' => $this->getValueByHeader($row, $headerMap, 'pemakai'),
            'lokasi_distribusi' => $this->getValueByHeader($row, $headerMap, 'lokasi_distribusi'),
            'hilang' => $this->parseBoolean($this->getValueByHeader($row, $headerMap, 'hilang')),
        ];

        Alat::create($data);

        Log::info("Created new alat from import", [
            'row' => $rowNumber,
            'nama_alat' => $namaAlat,
            'kode_alat' => $data['kode_alat']
        ]);

        $this->successCount++;
    }

    /**
     * Ambil nilai dari row berdasarkan header
     */
    private function getValueByHeader($row, $headerMap, $columnName)
    {
        $normalizedName = strtolower(str_replace([' ', '.', '-'], ['_', '', '_'], $columnName));

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

        $value = strtolower(trim($value));
        $truthyValues = ['true', '1', 'yes', 'ya', 'y'];
        return in_array($value, $truthyValues);
    }
}
