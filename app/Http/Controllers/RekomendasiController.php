<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Fasilitas;

class RekomendasiController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();
        return view('home', compact('fasilitas'));
    }

    public function proses(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'harga_max' => 'required|numeric|min:0',
            'jarak_max' => 'required|numeric|min:0',
            'jenis_kost' => 'required|in:putra,putri,campur',
            'fasilitas' => 'nullable|array'
        ]);

        // Simpan input pencarian ke session untuk digunakan di halaman analisis perhitungan
        $preferensi = [
            'harga_max' => $request->harga_max,
            'jarak_max' => $request->jarak_max,
            'jenis_kost' => $request->jenis_kost,
            'fasilitas' => $request->fasilitas ?? []
        ];
        session(['preferensi_rekomendasi' => $preferensi]);

        // 2. Hitung Rekomendasi
        $koleksiHasil = $this->hitungRekomendasi(
            $preferensi['harga_max'],
            $preferensi['jarak_max'],
            $preferensi['jenis_kost'],
            $preferensi['fasilitas']
        );

        // 3. Pisahkan Utama (tersedia) dan Alternatif (penuh) lalu urutkan berdasarkan skor tertinggi
        $utama = $koleksiHasil->where('status', 'tersedia')->sortByDesc('skor_total')->values();
        $alternatif = $koleksiHasil->where('status', 'penuh')->filter(function ($item) {
            return $item->skor_total > 3; // Hanya tampilkan alternatif jika kecocokan > 30%
        })->sortByDesc('skor_total')->values();

        return view('hasil', compact('utama', 'alternatif'));
    }

    public function prosesPerhitungan()
    {
        $preferensi = session('preferensi_rekomendasi');

        if (!$preferensi) {
            return redirect()->route('home')->with('error', 'Silakan tentukan preferensi pencarian terlebih dahulu.');
        }

        $koleksiHasil = $this->hitungRekomendasi(
            $preferensi['harga_max'],
            $preferensi['jarak_max'],
            $preferensi['jenis_kost'],
            $preferensi['fasilitas']
        );

        // Urutkan semua kost berdasarkan skor tertinggi untuk perangkingan
        $semuaKost = $koleksiHasil->sortByDesc('skor_total')->values();

        return view('proses_perhitungan', compact('semuaKost', 'preferensi'));
    }

    public function detailPerhitungan($id)
    {
        $preferensi = session('preferensi_rekomendasi');

        if (!$preferensi) {
            return redirect()->route('home')->with('error', 'Silakan tentukan preferensi pencarian terlebih dahulu.');
        }

        $koleksiHasil = $this->hitungRekomendasi(
            $preferensi['harga_max'],
            $preferensi['jarak_max'],
            $preferensi['jenis_kost'],
            $preferensi['fasilitas']
        );

        // Cari kost terpilih beserta rank globalnya
        $semuaKostSorted = $koleksiHasil->sortByDesc('skor_total')->values();
        
        $kost = null;
        $rank = 0;
        foreach ($semuaKostSorted as $index => $item) {
            if ($item->id == $id) {
                $kost = $item;
                $rank = $index + 1;
                break;
            }
        }

        if (!$kost) {
            abort(404, 'Kost tidak ditemukan');
        }

        return view('detail_perhitungan', compact('kost', 'preferensi', 'rank'));
    }

    private function hitungRekomendasi($hargaMax, $jarakMax, $jenisKost, $selectedFasilitas)
    {
        $fasilitasParkir = Fasilitas::where('nama_fasilitas', 'Parkir')->first();
        $parkirId = $fasilitasParkir ? $fasilitasParkir->id : -1;

        $semuaKost = Kost::with('fasilitas')->get();
        $hasil = [];

        foreach ($semuaKost as $kost) {
            // Rule 1: Harga <= Harga Max (Skor: 3.0)
            $isHargaMatch = $kost->harga <= $hargaMax;
            $skorHarga = $isHargaMatch ? 3.0 : 0.0;
            $penjelasanHarga = $isHargaMatch 
                ? "Harga kost (Rp " . number_format($kost->harga, 0, ',', '.') . ") sesuai budget (<= Rp " . number_format($hargaMax, 0, ',', '.') . ")"
                : "Harga kost (Rp " . number_format($kost->harga, 0, ',', '.') . ") melebihi budget (> Rp " . number_format($hargaMax, 0, ',', '.') . ")";

            // Rule 2: Jarak <= Jarak Max (Skor: 3.0)
            $isJarakMatch = $kost->jarak <= $jarakMax;
            $skorJarak = $isJarakMatch ? 3.0 : 0.0;
            $penjelasanJarak = $isJarakMatch 
                ? "Jarak kost ({$kost->jarak} m) sesuai preferensi (<= {$jarakMax} m)"
                : "Jarak kost ({$kost->jarak} m) melebihi batas preferensi (> {$jarakMax} m)";

            // Rule 3: Jenis Kost (Skor: 1.0)
            $isJenisMatch = $kost->jenis_kost === $jenisKost;
            $skorJenis = $isJenisMatch ? 1.0 : 0.0;
            $penjelasanJenis = $isJenisMatch 
                ? "Tipe kost sesuai (" . ucfirst($kost->jenis_kost) . ")"
                : "Tipe kost tidak sesuai (Kost: " . ucfirst($kost->jenis_kost) . ", Preferensi: " . ucfirst($jenisKost) . ")";

            // Rule 4: Fasilitas Pilihan (Skor: 2.0)
            $kostFasilitasIds = $kost->fasilitas->pluck('id')->toArray();
            $k = count($selectedFasilitas);
            $m = 0;
            $fasilitasCocokList = [];
            $fasilitasTidakCocokList = [];

            if ($k > 0) {
                foreach ($selectedFasilitas as $f_id) {
                    if (in_array($f_id, $kostFasilitasIds)) {
                        $m++;
                        $f_nama = $kost->fasilitas->firstWhere('id', $f_id)->nama_fasilitas ?? '';
                        if ($f_nama) {
                            $fasilitasCocokList[] = $f_nama;
                        }
                    } else {
                        $f_model = Fasilitas::find($f_id);
                        if ($f_model) {
                            $fasilitasTidakCocokList[] = $f_model->nama_fasilitas;
                        }
                    }
                }
                $skorFasilitas = 2.0 * ($m / $k);
                $isFasilitasMatch = $m > 0;
                $penjelasanFasilitas = "Cocok {$m} dari {$k} fasilitas pilihan (" . implode(', ', $fasilitasCocokList) . ")";
                if (count($fasilitasTidakCocokList) > 0) {
                    $penjelasanFasilitas .= ". Tidak cocok: " . implode(', ', $fasilitasTidakCocokList);
                }
            } else {
                $skorFasilitas = 2.0;
                $isFasilitasMatch = true;
                $penjelasanFasilitas = "Tidak ada fasilitas spesifik yang dipilih (Kriteria terpenuhi secara default)";
            }

            // Rule 5: Parkir (Skor: 1.0)
            $hasParkir = in_array($parkirId, $kostFasilitasIds);
            $skorParkir = $hasParkir ? 1.0 : 0.0;
            $penjelasanParkir = $hasParkir 
                ? "Tersedia fasilitas parkir" 
                : "Fasilitas parkir tidak tersedia";

            // Total Skor (Maksimal 10.0)
            $skorTotal = $skorHarga + $skorJarak + $skorJenis + $skorFasilitas + $skorParkir;
            $persentase = ($skorTotal / 10.0) * 100;

            // Generate Alasan Rekomendasi (untuk kompabilitas tampilan lama)
            $alasan = [];
            if ($isHargaMatch) $alasan[] = "Harga sesuai budget";
            if ($isJarakMatch) $alasan[] = "Lokasi sesuai preferensi";
            if ($isJenisMatch) $alasan[] = "Jenis kost sesuai pilihan user";
            if ($k > 0 && $m > 0) $alasan[] = "Fasilitas sesuai: " . implode(', ', $fasilitasCocokList);
            if ($hasParkir) $alasan[] = "Tersedia parkir";

            // Pasang data perhitungan ke properti dinamis kost
            $kost->skor_total = $skorTotal;
            $kost->persentase = round($persentase);
            $kost->alasan_rekomendasi = $alasan;

            // Metadata lengkap untuk halaman penjelasan transparansi
            $kost->detail_perhitungan = [
                'harga' => [
                    'nama' => 'Harga Kost',
                    'nilai_kost' => 'Rp ' . number_format($kost->harga, 0, ',', '.'),
                    'input_user' => 'Rp ' . number_format($hargaMax, 0, ',', '.'),
                    'bobot' => 3.0,
                    'skor' => $skorHarga,
                    'is_match' => $isHargaMatch,
                    'penjelasan' => $penjelasanHarga
                ],
                'jarak' => [
                    'nama' => 'Jarak Kost',
                    'nilai_kost' => $kost->jarak . ' Meter',
                    'input_user' => $jarakMax . ' Meter',
                    'bobot' => 3.0,
                    'skor' => $skorJarak,
                    'is_match' => $isJarakMatch,
                    'penjelasan' => $penjelasanJarak
                ],
                'jenis_kost' => [
                    'nama' => 'Jenis Kost',
                    'nilai_kost' => ucfirst($kost->jenis_kost),
                    'input_user' => ucfirst($jenisKost),
                    'bobot' => 1.0,
                    'skor' => $skorJenis,
                    'is_match' => $isJenisMatch,
                    'penjelasan' => $penjelasanJenis
                ],
                'fasilitas' => [
                    'nama' => 'Fasilitas Pilihan',
                    'nilai_kost' => $m . ' Cocok',
                    'input_user' => $k . ' Dipilih',
                    'bobot' => 2.0,
                    'skor' => round($skorFasilitas, 2),
                    'is_match' => $isFasilitasMatch,
                    'penjelasan' => $penjelasanFasilitas
                ],
                'parkir' => [
                    'nama' => 'Fasilitas Parkir',
                    'nilai_kost' => $hasParkir ? 'Tersedia' : 'Tidak Tersedia',
                    'input_user' => 'Diutamakan (Parkir)',
                    'bobot' => 1.0,
                    'skor' => $skorParkir,
                    'is_match' => $hasParkir,
                    'penjelasan' => $penjelasanParkir
                ],
            ];

            $hasil[] = $kost;
        }

        return collect($hasil);
    }
}
