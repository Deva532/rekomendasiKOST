@extends('layouts.app')

@section('content')
<style>
    .bg-cream-hero { background: linear-gradient(160deg, #fef3c7 0%, #fde68a 40%, #fef9f0 100%); }
    .glass-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(254, 243, 199, 0.8);
        box-shadow: 0 20px 60px rgba(180, 83, 9, 0.08);
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[calc(100vh-3.5rem-3.25rem)]">
    
    <!-- Breadcrumb & Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex text-xs font-bold uppercase tracking-wider text-amber-800 mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-amber-600 transition-colors">Cari Kost</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-amber-500 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-gray-400">Proses Perhitungan</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Proses Perhitungan Rekomendasi</h1>
            <p class="mt-1 text-sm font-medium text-gray-500">Matriks perbandingan kecocokan alternatif kost menggunakan pembobotan Rule-Based.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 hover:border-amber-300 hover:bg-amber-50 text-gray-700 text-sm font-bold rounded-xl transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Hasil
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-br from-amber-600 to-orange-500 hover:opacity-90 text-white text-sm font-bold rounded-xl transition-all shadow-sm shadow-amber-200">
                Ubah Filter Preferensi
            </a>
        </div>
    </div>

    <!-- Info Box Preferensi User -->
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-8">
        <h3 class="text-xs font-bold text-amber-900 uppercase tracking-widest mb-3">Kriteria Pencarian Anda </h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white p-3 rounded-xl border border-amber-100 shadow-sm">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Budget Maksimal</p>
                <p class="text-sm font-extrabold text-gray-800">Rp{{ number_format($preferensi['harga_max'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-3 rounded-xl border border-amber-100 shadow-sm">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Jarak Maksimal</p>
                <p class="text-sm font-extrabold text-gray-800">{{ $preferensi['jarak_max'] }} Meter</p>
            </div>
            <div class="bg-white p-3 rounded-xl border border-amber-100 shadow-sm">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Jenis Kost</p>
                <p class="text-sm font-extrabold text-gray-800">🧑👩 {{ ucfirst($preferensi['jenis_kost']) }}</p>
            </div>
            <div class="bg-white p-3 rounded-xl border border-amber-100 shadow-sm">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Jumlah Fasilitas Pilihan</p>
                <p class="text-sm font-extrabold text-gray-800">{{ count($preferensi['fasilitas']) }} Dipilih</p>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="glass-card rounded-[24px] overflow-hidden">
        <div class="px-6 py-5 border-b border-amber-100 bg-amber-50/20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-amber-950">Matriks Perhitungan Skor</h2>
                <p class="text-xs text-amber-800/80 font-medium">Berdasarkan total bobot kriteria sebesar 10.0 (100%)</p>
            </div>
            <div class="text-[11px] font-bold text-amber-800 bg-amber-100 px-3 py-1 rounded-full self-start sm:self-auto">
                Model: Knowledge-Based Recommendation
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-amber-100 text-[10px] font-black text-amber-900 uppercase tracking-wider">
                        <th class="py-4 px-6 text-center">Rank</th>
                        <th class="py-4 px-6">Nama Kost</th>
                        <th class="py-4 px-6 text-center">Tipe</th>
                        <th class="py-4 px-6 text-center bg-amber-50/30">K1: Harga<br><span class="text-[9px] font-semibold text-amber-600">(Bobot: 3.0)</span></th>
                        <th class="py-4 px-6 text-center bg-amber-50/30">K2: Jarak<br><span class="text-[9px] font-semibold text-amber-600">(Bobot: 3.0)</span></th>
                        <th class="py-4 px-6 text-center bg-amber-50/30">K3: Gender<br><span class="text-[9px] font-semibold text-amber-600">(Bobot: 1.0)</span></th>
                        <th class="py-4 px-6 text-center bg-amber-50/30">K4: Fasilitas<br><span class="text-[9px] font-semibold text-amber-600">(Bobot: 2.0)</span></th>
                        <th class="py-4 px-6 text-center bg-amber-50/30">K5: Parkir<br><span class="text-[9px] font-semibold text-amber-600">(Bobot: 1.0)</span></th>
                        <th class="py-4 px-6 text-center text-indigo-900 bg-indigo-50/50">Total Skor<br><span class="text-[9px] font-semibold text-indigo-600">(Max: 10.0)</span></th>
                        <th class="py-4 px-6 text-center text-purple-900 bg-purple-50/50">Persentase</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm font-semibold text-gray-700">
                    @foreach($semuaKost as $index => $kost)
                        <tr class="hover:bg-amber-50/10 transition-colors">
                            <!-- Rank -->
                            <td class="py-4 px-6 text-center font-black">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full {{ $index === 0 ? 'bg-amber-500 text-white shadow-sm' : ($index === 1 ? 'bg-gray-300 text-gray-800' : ($index === 2 ? 'bg-amber-700 text-white' : 'bg-gray-100 text-gray-500')) }}">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <!-- Nama Kost -->
                            <td class="py-4 px-6">
                                <div class="font-extrabold text-gray-900">{{ $kost->nama_kost }}</div>
                                <div class="text-[10px] text-gray-400 font-medium line-clamp-1 mt-0.5">{{ $kost->alamat }}</div>
                            </td>
                            <!-- Tipe -->
                            <td class="py-4 px-6 text-center">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] uppercase font-bold tracking-wide {{ $kost->jenis_kost === 'putra' ? 'bg-blue-55 text-blue-700 bg-blue-50' : ($kost->jenis_kost === 'putri' ? 'bg-rose-50 text-rose-700' : 'bg-purple-50 text-purple-700') }}">
                                    {{ $kost->jenis_kost }}
                                </span>
                            </td>
                            <!-- C1 (Harga) -->
                            <td class="py-4 px-6 text-center bg-amber-50/10">
                                <span class="block text-gray-900 text-xs">Rp{{ number_format($kost->harga / 1000, 0, ',', '.') }}rb</span>
                                <span class="inline-block text-[11px] mt-1 font-black {{ $kost->detail_perhitungan['harga']['is_match'] ? 'text-green-600' : 'text-red-500' }}">
                                    {{ number_format($kost->detail_perhitungan['harga']['skor'], 1) }}
                                </span>
                            </td>
                            <!-- C2 (Jarak) -->
                            <td class="py-4 px-6 text-center bg-amber-50/10">
                                <span class="block text-gray-900 text-xs">{{ $kost->jarak }}m</span>
                                <span class="inline-block text-[11px] mt-1 font-black {{ $kost->detail_perhitungan['jarak']['is_match'] ? 'text-green-600' : 'text-red-500' }}">
                                    {{ number_format($kost->detail_perhitungan['jarak']['skor'], 1) }}
                                </span>
                            </td>
                            <!-- C3 (Gender/Jenis Kost) -->
                            <td class="py-4 px-6 text-center bg-amber-50/10">
                                <span class="block text-gray-500 text-[10px] uppercase">{{ $kost->jenis_kost }}</span>
                                <span class="inline-block text-[11px] mt-1 font-black {{ $kost->detail_perhitungan['jenis_kost']['is_match'] ? 'text-green-600' : 'text-red-500' }}">
                                    {{ number_format($kost->detail_perhitungan['jenis_kost']['skor'], 1) }}
                                </span>
                            </td>
                            <!-- C4 (Fasilitas Pilihan) -->
                            <td class="py-4 px-6 text-center bg-amber-50/10">
                                <span class="block text-gray-500 text-[10px]">{{ $kost->detail_perhitungan['fasilitas']['nilai_kost'] }}</span>
                                <span class="inline-block text-[11px] mt-1 font-black {{ $kost->detail_perhitungan['fasilitas']['skor'] > 0 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ number_format($kost->detail_perhitungan['fasilitas']['skor'], 2) }}
                                </span>
                            </td>
                            <!-- C5 (Parkir) -->
                            <td class="py-4 px-6 text-center bg-amber-50/10">
                                <span class="block text-gray-500 text-[10px]">{{ $kost->detail_perhitungan['parkir']['nilai_kost'] }}</span>
                                <span class="inline-block text-[11px] mt-1 font-black {{ $kost->detail_perhitungan['parkir']['is_match'] ? 'text-green-600' : 'text-red-500' }}">
                                    {{ number_format($kost->detail_perhitungan['parkir']['skor'], 1) }}
                                </span>
                            </td>
                            <!-- Total Skor -->
                            <td class="py-4 px-6 text-center text-indigo-700 bg-indigo-50/20 font-black text-base">
                                {{ number_format($kost->skor_total, 2) }}
                            </td>
                            <!-- Persentase -->
                            <td class="py-4 px-6 text-center bg-purple-50/20 font-black text-purple-700">
                                {{ $kost->persentase }}%
                            </td>
                            <!-- Aksi -->
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('rekomendasi.detail', $kost->id) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-indigo-200 rounded-lg text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 shadow-sm transition-all">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footnotes / Academic Legend -->
        <div class="px-6 py-5 border-t border-amber-100 bg-gray-50 text-[11px] text-gray-500 font-medium">
            <h4 class="font-extrabold text-amber-900 uppercase tracking-widest text-xs mb-2">Penjelasan Formula Pembobotan Akademik</h4>
            <ul class="list-disc pl-4 space-y-1.5">
                <li><strong>C1 (Harga)</strong>: Bobot Maksimal 3.0. Menggunakan fungsi pembatas biner. Skor bernilai 3.0 jika harga kost di bawah budget maksimal user, dan 0.0 jika melebihi budget.</li>
                <li><strong>C2 (Jarak)</strong>: Bobot Maksimal 3.0. Menggunakan fungsi pembatas biner. Skor bernilai 3.0 jika jarak kost di bawah jarak maksimal preferensi user, dan 0.0 jika melebihi.</li>
                <li><strong>C3 (Tipe/Jenis Kost)</strong>: Bobot Maksimal 1.0. Kriteria kecocokan gender. Bernilai 1.0 jika jenis kost sesuai input pengguna, dan 0.0 jika tidak cocok.</li>
                <li><strong>C4 (Fasilitas Pilihan)</strong>: Bobot Maksimal 2.0. Skor dihitung secara proporsional berdasarkan rasio jumlah fasilitas yang dimiliki kost terhadap total fasilitas yang dicari pengguna: $\text{Skor} = 2.0 \times \left( \frac{\text{Cocok}}{\text{Dipilih}} \right)$.</li>
                <li><strong>C5 (Fasilitas Parkir)</strong>: Bobot Maksimal 1.0. Kriteria kenyamanan kendaraan. Bernilai 1.0 jika kost memiliki fasilitas Parkir, dan 0.0 jika tidak memiliki.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
