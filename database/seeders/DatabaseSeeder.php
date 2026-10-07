<?php

namespace Database\Seeders;

use App\Models\Aset;
use App\Models\Banner;
use App\Models\Debitur;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@bsiaset.test'], [
            'name' => 'Administrator Pusat',
            'password' => 'admin123',
            'role' => 'admin',
            'no_hp' => '081200000001',
        ]);

        User::updateOrCreate(['email' => 'user@bsiaset.test'], [
            'name' => 'Fitri Nur Aisyah',
            'password' => 'user123',
            'role' => 'user',
            'no_hp' => '081200000002',
        ]);

        $debiturData = [
            ['1001234501', 'Ahmad Fauzi', 'LN-2023-000101', 'Konsumer', 'Griya Hasanah', 'KC Jakarta Thamrin', 5, 845000000, true],
            ['1001234502', 'Siti Aminah', 'LN-2023-000102', 'Mikro', 'Modal Kerja Mikro', 'KC Bandung Asia Afrika', 4, 210000000, true],
            ['1001234503', 'Budi Santoso', 'LN-2022-000103', 'Komersial', 'Modal Kerja', 'KC Surabaya Darmo', 3, 1750000000, true],
            ['1001234504', 'Dewi Lestari', 'LN-2024-000104', 'Konsumer', 'Griya Hasanah', 'KC Semarang Pandanaran', 1, 560000000, false],
            ['1001234505', 'Rudi Hartono', 'LN-2024-000105', 'Mikro', 'KUR Mikro', 'KC Medan Ahmad Yani', 2, 95000000, false],
            ['1001234506', 'Nur Hidayah', 'LN-2023-000106', 'Konsumer', 'Oto Hasanah', 'KC Makassar Sam Ratulangi', 1, 180000000, false],
            ['1001234507', 'Hendra Wijaya', 'LN-2022-000107', 'Komersial', 'Investasi', 'KC Bekasi Juanda', 5, 3250000000, true],
            ['1001234508', 'Maya Sari', 'LN-2024-000108', 'Mikro', 'Modal Kerja Mikro', 'KC Yogyakarta Sudirman', 2, 132000000, false],
            ['1001234509', 'Agus Setiawan', 'LN-2023-000109', 'Komersial', 'Modal Kerja', 'KC Tangerang BSD', 4, 2100000000, true],
            ['1001234510', 'Rina Marlina', 'LN-2024-000110', 'Konsumer', 'Griya Hasanah', 'KC Depok Margonda', 1, 640000000, false],
        ];

        $debiturs = [];
        foreach ($debiturData as [$cif, $nama, $loan, $segmen, $produk, $cabang, $kol, $os, $npf]) {
            $debiturs[] = Debitur::updateOrCreate(['no_loan' => $loan], [
                'cif' => $cif,
                'nama' => $nama,
                'segmen' => $segmen,
                'produk' => $produk,
                'cabang_pengelola' => $cabang,
                'kolektibilitas' => $kol,
                'os_pokok' => $os,
                'is_npf' => $npf,
            ]);
        }

        $asetData = [
            ['AST-001', 'Rumah', 'Rumah 2 Lantai Bumi Serpong', 'Jl. Anggrek Loka Blok C No. 12', 'Tangerang Selatan', 120, 150, 'SHM', 950000000, 'images/rumah.jpg'],
            ['AST-002', 'Tanah', 'Tanah Kavling Siap Bangun', 'Jl. Raya Sleman KM 8', 'Sleman', 300, 0, 'SHM', 450000000, 'images/tanah.jpg'],
            ['AST-003', 'Ruko', 'Ruko 3 Lantai Pusat Kota', 'Jl. Pahlawan No. 45', 'Semarang', 72, 180, 'HGB', 1650000000, 'images/ruko.jpg'],
            ['AST-004', 'Gudang', 'Gudang Kawasan Industri MM2100', 'Kawasan Industri MM2100 Blok F', 'Bekasi', 1500, 1000, 'HGB', 7800000000, 'images/gudang.jpg'],
            ['AST-005', 'Rumah', 'Rumah Cluster Minimalis', 'Jl. Melati Indah No. 8', 'Depok', 90, 100, 'SHM', 720000000, 'images/rumah.jpg'],
            ['AST-006', 'Tanah', 'Tanah Pekarangan Pinggir Jalan', 'Jl. Kaliurang KM 12', 'Yogyakarta', 520, 0, 'SHM', 780000000, 'images/tanah.jpg'],
            ['AST-007', 'Ruko', 'Ruko Gandeng 2 Unit', 'Jl. Ahmad Yani No. 112', 'Medan', 140, 280, 'HGB', 2450000000, 'images/ruko.jpg'],
            ['AST-008', 'Gudang', 'Gudang Logistik Rungkut', 'Jl. Rungkut Industri III No. 20', 'Surabaya', 900, 650, 'HGB', 4300000000, 'images/gudang.jpg'],
            ['AST-009', 'Rumah', 'Rumah Tua Area Strategis', 'Jl. Braga Dalam No. 5', 'Bandung', 200, 170, 'SHM', 2100000000, 'images/rumah.jpg'],
            ['AST-010', 'Tanah', 'Tanah Komersial Tepi Jalan Raya', 'Jl. Poros Makassar No. 30', 'Makassar', 800, 0, 'SHM', 1600000000, 'images/tanah.jpg'],
        ];

        foreach ($asetData as $i => [$kode, $jenis, $nama, $alamat, $kota, $lt, $lb, $sert, $harga, $gambar]) {
            Aset::updateOrCreate(['kode' => $kode], [
                'debitur_id' => $debiturs[$i % count($debiturs)]->id,
                'jenis' => $jenis,
                'nama' => $nama,
                'alamat' => $alamat,
                'kota' => $kota,
                'luas_tanah' => $lt,
                'luas_bangunan' => $lb,
                'sertifikat' => $sert,
                'harga_estimasi' => $harga,
                'gambar' => $gambar,
                'booklet_ready' => true,
                'spesifikasi' => "Kondisi bangunan terawat.\nListrik PLN, sumber air PDAM/sumur bor.\nAkses jalan dapat dilalui 2 mobil.\nLingkungan aman dan bebas banjir.",
                'legalitas' => "Sertifikat atas nama debitur, tidak dalam sengketa.\nPBB terbayar sampai tahun berjalan.\nIMB/PBG tersedia untuk aset bangunan.",
            ]);
        }

        Banner::updateOrCreate(['judul' => 'Program Lelang Aset Agunan Triwulan Ini'], [
            'deskripsi' => 'Ikuti lelang aset agunan BSI dengan harga menarik di seluruh cabang.',
            'aktif' => true,
        ]);
        Banner::updateOrCreate(['judul' => 'Pembiayaan Griya Hasanah'], [
            'deskripsi' => 'Wujudkan hunian impian dengan angsuran tetap sampai lunas.',
            'aktif' => true,
        ]);
    }
}
