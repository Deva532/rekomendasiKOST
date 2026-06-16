<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kost;
use App\Models\Fasilitas;

class KostSeeder extends Seeder
{
    public function run(): void
    {
        $kosts = [
            [
                'nama_kost' => 'Kost Putra Bahagia',
                'harga' => 400000,
                'jarak' => 500,
                'jenis_kost' => 'putra',
                'alamat' => 'Jl. Brawijaya No. 1, Pare',
                'no_hp' => '6281234567890',
                'status' => 'tersedia',
                'fasilitas' => ['WiFi', 'Kasur', 'Lemari', 'Parkir']
            ],
            [
                'nama_kost' => 'Kost Putri Kinasih',
                'harga' => 600000,
                'jarak' => 300,
                'jenis_kost' => 'putri',
                'alamat' => 'Jl. Aster No. 12, Pare',
                'no_hp' => '6281234567891',
                'status' => 'tersedia',
                'fasilitas' => ['WiFi', 'Kasur', 'Lemari', 'Kamar Mandi Dalam', 'Parkir', 'Dapur Umum']
            ],
            [
                'nama_kost' => 'Kost Campur Mawar',
                'harga' => 500000,
                'jarak' => 800,
                'jenis_kost' => 'campur',
                'alamat' => 'Jl. Mawar No. 34, Pare',
                'no_hp' => '6281234567892',
                'status' => 'tersedia',
                'fasilitas' => ['WiFi', 'Kasur', 'Meja Belajar']
            ],
            [
                'nama_kost' => 'Kost Putra Mandiri',
                'harga' => 350000,
                'jarak' => 1200,
                'jenis_kost' => 'putra',
                'alamat' => 'Jl. Sudirman No. 9, Pare',
                'no_hp' => '6281234567893',
                'status' => 'tersedia',
                'fasilitas' => ['Kasur', 'Lemari', 'Kipas Angin', 'Parkir']
            ],
            [
                'nama_kost' => 'Kost Putri Anggrek (Eksklusif)',
                'harga' => 1200000,
                'jarak' => 200,
                'jenis_kost' => 'putri',
                'alamat' => 'Jl. Anggrek No. 5, Pare',
                'no_hp' => '6281234567894',
                'status' => 'tersedia',
                'fasilitas' => ['WiFi', 'Kasur', 'Lemari', 'Kamar Mandi Dalam', 'AC', 'Meja Belajar', 'Parkir']
            ],
            [
                'nama_kost' => 'Kost Putra Melati',
                'harga' => 450000,
                'jarak' => 450,
                'jenis_kost' => 'putra',
                'alamat' => 'Jl. Flamboyan No. 8, Pare',
                'no_hp' => '6281234567895',
                'status' => 'penuh',
                'fasilitas' => ['WiFi', 'Kasur', 'Lemari', 'Dapur Umum']
            ],
            [
                'nama_kost' => 'Kost Putri Kenanga',
                'harga' => 550000,
                'jarak' => 1000,
                'jenis_kost' => 'putri',
                'alamat' => 'Jl. Kenanga No. 2, Pare',
                'no_hp' => '6281234567896',
                'status' => 'tersedia',
                'fasilitas' => ['WiFi', 'Kasur', 'Kamar Mandi Dalam', 'Mesin Cuci']
            ],
            [
                'nama_kost' => 'Kost Campur Nyaman',
                'harga' => 800000,
                'jarak' => 700,
                'jenis_kost' => 'campur',
                'alamat' => 'Jl. Veteran No. 11, Pare',
                'no_hp' => '6281234567897',
                'status' => 'tersedia',
                'fasilitas' => ['WiFi', 'Kasur', 'Lemari', 'Kamar Mandi Dalam', 'Parkir', 'Dapur Umum', 'AC']
            ],
            [
                'nama_kost' => 'Kost Putri Hemat',
                'harga' => 300000,
                'jarak' => 1500,
                'jenis_kost' => 'putri',
                'alamat' => 'Jl. Pahlawan No. 4, Pare',
                'no_hp' => '6281234567898',
                'status' => 'tersedia',
                'fasilitas' => ['Kasur', 'Dapur Umum']
            ],
            [
                'nama_kost' => 'Kost Putra Elite',
                'harga' => 1000000,
                'jarak' => 150,
                'jenis_kost' => 'putra',
                'alamat' => 'Jl. Cempaka No. 7, Pare',
                'no_hp' => '6281234567899',
                'status' => 'penuh',
                'fasilitas' => ['WiFi', 'Kasur', 'Lemari', 'Kamar Mandi Dalam', 'AC', 'Parkir']
            ],
        ];

        foreach ($kosts as $k) {
            $fasilitasNames = $k['fasilitas'];
            unset($k['fasilitas']); // Remove array before inserting to Kost

            $newKost = Kost::create($k);

            // Attach fasilitas
            $fasilitasIds = Fasilitas::whereIn('nama_fasilitas', $fasilitasNames)->pluck('id')->toArray();
            $newKost->fasilitas()->attach($fasilitasIds);
        }
    }
}
