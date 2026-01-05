<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alat;

class AlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alats = [
            // Kategori: Elektronik - Komputer & Laptop
            [
                'kode_alat' => 'LTP001',
                'nama_alat' => 'Laptop Asus ROG Strix G15',
                'deskripsi' => 'Laptop gaming dengan processor Intel Core i7-12700H, RAM 16GB, SSD 512GB, VGA RTX 3060',
                'jumlah_total' => 5,
                'jumlah_tersedia' => 5,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang A - Rak 1'
            ],
            [
                'kode_alat' => 'LTP002',
                'nama_alat' => 'Laptop HP Pavilion 14',
                'deskripsi' => 'Laptop untuk keperluan office dengan Intel Core i5, RAM 8GB, SSD 256GB',
                'jumlah_total' => 10,
                'jumlah_tersedia' => 10,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang A - Rak 1'
            ],
            [
                'kode_alat' => 'PC001',
                'nama_alat' => 'PC Desktop Dell OptiPlex',
                'deskripsi' => 'PC Desktop dengan Intel Core i5, RAM 16GB, SSD 512GB, Monitor 24 inch',
                'jumlah_total' => 8,
                'jumlah_tersedia' => 8,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang A - Rak 2'
            ],

            // Kategori: Elektronik - Proyektor & Presentasi
            [
                'kode_alat' => 'PRJ001',
                'nama_alat' => 'Projector Epson EB-X06',
                'deskripsi' => 'Proyektor 3LCD dengan brightness 3600 lumens, resolusi XGA',
                'jumlah_total' => 6,
                'jumlah_tersedia' => 6,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang B - Rak 1'
            ],
            [
                'kode_alat' => 'PRJ002',
                'nama_alat' => 'Projector BenQ MH535',
                'deskripsi' => 'Proyektor Full HD 1080p dengan brightness 3600 lumens',
                'jumlah_total' => 4,
                'jumlah_tersedia' => 4,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang B - Rak 1'
            ],
            [
                'kode_alat' => 'SCN001',
                'nama_alat' => 'Layar Proyektor Tripod 70 inch',
                'deskripsi' => 'Layar proyektor portable dengan tripod, ukuran 70 inch',
                'jumlah_total' => 8,
                'jumlah_tersedia' => 8,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang B - Rak 2'
            ],

            // Kategori: Elektronik - Kamera & Fotografi
            [
                'kode_alat' => 'CAM001',
                'nama_alat' => 'Kamera Canon EOS 80D',
                'deskripsi' => 'Kamera DSLR 24.2MP dengan lensa 18-55mm IS STM, untuk dokumentasi dan fotografi',
                'jumlah_total' => 3,
                'jumlah_tersedia' => 3,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang C - Rak 1'
            ],
            [
                'kode_alat' => 'CAM002',
                'nama_alat' => 'Kamera Sony A6400',
                'deskripsi' => 'Kamera Mirrorless 24.2MP dengan lensa 16-50mm, cocok untuk vlog dan foto',
                'jumlah_total' => 2,
                'jumlah_tersedia' => 2,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang C - Rak 1'
            ],
            [
                'kode_alat' => 'VID001',
                'nama_alat' => 'Video Camera Sony Handycam',
                'deskripsi' => 'Kamera video dengan resolusi Full HD, optical zoom 30x',
                'jumlah_total' => 4,
                'jumlah_tersedia' => 4,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang C - Rak 1'
            ],
            [
                'kode_alat' => 'TRP001',
                'nama_alat' => 'Tripod Kamera Manfrotto',
                'deskripsi' => 'Tripod profesional dengan head 3-way, tinggi maksimal 165cm',
                'jumlah_total' => 6,
                'jumlah_tersedia' => 6,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang C - Rak 2'
            ],

            // Kategori: Elektronik - Audio
            [
                'kode_alat' => 'MIC001',
                'nama_alat' => 'Microphone Wireless Shure',
                'deskripsi' => 'Wireless microphone system dengan 2 handheld mic',
                'jumlah_total' => 5,
                'jumlah_tersedia' => 5,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang B - Rak 3'
            ],
            [
                'kode_alat' => 'SPK001',
                'nama_alat' => 'Speaker Portable JBL Xtreme',
                'deskripsi' => 'Speaker bluetooth portable dengan power output 40W',
                'jumlah_total' => 8,
                'jumlah_tersedia' => 8,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang B - Rak 3'
            ],

            // Kategori: Elektronik - Networking
            [
                'kode_alat' => 'RTR001',
                'nama_alat' => 'Router WiFi TP-Link AC1750',
                'deskripsi' => 'Wireless router dual-band dengan kecepatan hingga 1750Mbps',
                'jumlah_total' => 10,
                'jumlah_tersedia' => 10,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang A - Rak 3'
            ],
            [
                'kode_alat' => 'SWT001',
                'nama_alat' => 'Network Switch 24 Port',
                'deskripsi' => 'Gigabit ethernet switch 24 port untuk networking',
                'jumlah_total' => 5,
                'jumlah_tersedia' => 5,
                'kondisi' => 'baik',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang A - Rak 3'
            ],

            // Kategori: Alat Tulis & ATK
            [
                'kode_alat' => 'WHB001',
                'nama_alat' => 'Whiteboard 120x240 cm',
                'deskripsi' => 'Papan tulis putih ukuran besar dengan stand roda',
                'jumlah_total' => 15,
                'jumlah_tersedia' => 15,
                'kondisi' => 'baik',
                'kategori' => 'Alat Tulis',
                'lokasi' => 'Gudang D - Area 1'
            ],
            [
                'kode_alat' => 'FLP001',
                'nama_alat' => 'Flipchart Stand',
                'deskripsi' => 'Stand flipchart dengan kertas ukuran 65x100 cm',
                'jumlah_total' => 10,
                'jumlah_tersedia' => 10,
                'kondisi' => 'baik',
                'kategori' => 'Alat Tulis',
                'lokasi' => 'Gudang D - Area 1'
            ],

            // Kategori: Peralatan Laboratorium
            [
                'kode_alat' => 'LAB001',
                'nama_alat' => 'Mikroskop Digital Olympus',
                'deskripsi' => 'Mikroskop digital dengan perbesaran 40-2000x, dilengkapi kamera',
                'jumlah_total' => 8,
                'jumlah_tersedia' => 8,
                'kondisi' => 'baik',
                'kategori' => 'Peralatan Laboratorium',
                'lokasi' => 'Laboratorium - Lemari 1'
            ],
            [
                'kode_alat' => 'LAB002',
                'nama_alat' => 'Multimeter Digital Fluke',
                'deskripsi' => 'Multimeter digital untuk pengukuran listrik AC/DC',
                'jumlah_total' => 15,
                'jumlah_tersedia' => 15,
                'kondisi' => 'baik',
                'kategori' => 'Peralatan Laboratorium',
                'lokasi' => 'Laboratorium - Lemari 2'
            ],
            [
                'kode_alat' => 'LAB003',
                'nama_alat' => 'Oscilloscope Digital Tektronix',
                'deskripsi' => 'Oscilloscope 2 channel dengan bandwidth 100MHz',
                'jumlah_total' => 5,
                'jumlah_tersedia' => 5,
                'kondisi' => 'baik',
                'kategori' => 'Peralatan Laboratorium',
                'lokasi' => 'Laboratorium - Lemari 2'
            ],

            // Kategori: Furniture & Perlengkapan
            [
                'kode_alat' => 'TBL001',
                'nama_alat' => 'Meja Lipat 180x80 cm',
                'deskripsi' => 'Meja lipat untuk acara dengan kaki besi, permukaan melamin',
                'jumlah_total' => 50,
                'jumlah_tersedia' => 50,
                'kondisi' => 'baik',
                'kategori' => 'Furniture',
                'lokasi' => 'Gudang E - Area 1'
            ],
            [
                'kode_alat' => 'CHR001',
                'nama_alat' => 'Kursi Lipat Chitose',
                'deskripsi' => 'Kursi lipat besi dengan dudukan plastik',
                'jumlah_total' => 100,
                'jumlah_tersedia' => 100,
                'kondisi' => 'baik',
                'kategori' => 'Furniture',
                'lokasi' => 'Gudang E - Area 2'
            ],
            [
                'kode_alat' => 'TNT001',
                'nama_alat' => 'Tenda Kerucut 3x3 meter',
                'deskripsi' => 'Tenda kerucut untuk acara outdoor',
                'jumlah_total' => 10,
                'jumlah_tersedia' => 10,
                'kondisi' => 'baik',
                'kategori' => 'Furniture',
                'lokasi' => 'Gudang E - Area 3'
            ],

            // Kategori: Alat Olahraga
            [
                'kode_alat' => 'SPT001',
                'nama_alat' => 'Bola Sepak Nike',
                'deskripsi' => 'Bola sepak ukuran standar size 5',
                'jumlah_total' => 20,
                'jumlah_tersedia' => 20,
                'kondisi' => 'baik',
                'kategori' => 'Alat Olahraga',
                'lokasi' => 'Gudang F - Rak Olahraga'
            ],
            [
                'kode_alat' => 'SPT002',
                'nama_alat' => 'Bola Basket Molten',
                'deskripsi' => 'Bola basket kulit sintetis ukuran 7',
                'jumlah_total' => 15,
                'jumlah_tersedia' => 15,
                'kondisi' => 'baik',
                'kategori' => 'Alat Olahraga',
                'lokasi' => 'Gudang F - Rak Olahraga'
            ],
            [
                'kode_alat' => 'SPT003',
                'nama_alat' => 'Net Badminton Portable',
                'deskripsi' => 'Net badminton portable dengan stand',
                'jumlah_total' => 8,
                'jumlah_tersedia' => 8,
                'kondisi' => 'baik',
                'kategori' => 'Alat Olahraga',
                'lokasi' => 'Gudang F - Rak Olahraga'
            ],

            // Beberapa alat dengan kondisi berbeda untuk testing
            [
                'kode_alat' => 'LTP003',
                'nama_alat' => 'Laptop Lenovo ThinkPad X1',
                'deskripsi' => 'Laptop business dengan Intel Core i7, RAM 16GB, kondisi perlu perbaikan keyboard',
                'jumlah_total' => 3,
                'jumlah_tersedia' => 3,
                'kondisi' => 'rusak_ringan',
                'kategori' => 'Elektronik',
                'lokasi' => 'Gudang A - Rak 1'
            ],
            [
                'kode_alat' => 'PRJ003',
                'nama_alat' => 'Projector Acer X118H',
                'deskripsi' => 'Proyektor sedang dalam perawatan rutin',
                'jumlah_total' => 2,
                'jumlah_tersedia' => 2,
                'kondisi' => 'maintenance',
                'kategori' => 'Elektronik',
                'lokasi' => 'Workshop Maintenance'
            ],
        ];

        foreach ($alats as $alat) {
            Alat::create($alat);
        }
    }
}
