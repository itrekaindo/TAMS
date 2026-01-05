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
            // Load file Excel
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Ambil header (baris pertama)
            $header = array_shift($rows);

            // Mapping header ke index
            $headerMap = array_flip(array_map('strtolower', array_map('trim', $header)));

            DB::beginTransaction();

            foreach ($rows as $index => $row) {
                // Skip baris kosong
                if (empty(array_filter($row))) {
                    continue;
                }

                try {
                    $this->processRow($row, $headerMap, $index + 2); // +2 karena baris 1 header, index mulai dari 0
                } catch (\Exception $e) {
                    $this->failedCount++;
                    $this->errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
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
            Log::error('Import error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function processRow($row, $headerMap, $rowNumber)
    {
        // Ambil data berdasarkan header
        $kodeAlat = $this->getValueByHeader($row, $headerMap, 'kode_alat');
        $namaAlat = $this->getValueByHeader($row, $headerMap, 'nama_alat');
        $jumlahTotal = $this->getValueByHeader($row, $headerMap, 'jumlah_total');

        // Validasi data wajib
        if (empty($kodeAlat) || empty($namaAlat) || empty($jumlahTotal)) {
            throw new \Exception("Data wajib tidak lengkap (kode_alat, nama_alat, jumlah_total)");
        }

        // Data yang akan disimpan
        $data = [
            'nama_alat' => $namaAlat,
            'deskripsi' => $this->getValueByHeader($row, $headerMap, 'deskripsi'),
            'jumlah_total' => (int) $jumlahTotal,
            'jumlah_tersedia' => (int) ($this->getValueByHeader($row, $headerMap, 'jumlah_tersedia') ?: $jumlahTotal),
            'kondisi' => $this->getValueByHeader($row, $headerMap, 'kondisi') ?: 'baik',
            'kategori' => $this->getValueByHeader($row, $headerMap, 'kategori'),
            'lokasi' => $this->getValueByHeader($row, $headerMap, 'lokasi'),
        ];

        // Validasi kondisi
        if (!in_array($data['kondisi'], ['baik', 'rusak_ringan', 'rusak_berat', 'maintenance'])) {
            $data['kondisi'] = 'baik';
        }

        // Cek apakah data sudah ada
        $existingAlat = Alat::where('kode_alat', $kodeAlat)->first();

        if ($existingAlat) {
            // Update
            $existingAlat->update($data);
        } else {
            // Insert
            Alat::create(array_merge(['kode_alat' => $kodeAlat], $data));
        }

        $this->successCount++;
    }

    private function getValueByHeader($row, $headerMap, $columnName)
    {
        $index = $headerMap[strtolower($columnName)] ?? null;

        if ($index === null) {
            return null;
        }

        return isset($row[$index]) ? trim($row[$index]) : null;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getFailedCount()
    {
        return $this->failedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
