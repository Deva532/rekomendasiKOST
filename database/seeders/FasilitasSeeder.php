<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fasilitas;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $fasilitas = [
            'WiFi',
            'Kamar Mandi Dalam',
            'Kasur',
            'Lemari',
            'Meja Belajar',
            'Parkir',
            'Dapur Umum',
            'AC',
            'Kipas Angin',
            'Mesin Cuci'
        ];

        foreach ($fasilitas as $f) {
            Fasilitas::create(['nama_fasilitas' => $f]);
        }
    }
}
