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

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-[calc(100vh-3.5rem-3.25rem)]">
    
    <!-- Breadcrumb & Back Actions -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <nav class="flex text-xs font-bold uppercase tracking-wider text-amber-800" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="hover:text-amber-600 transition-colors">Cari Kost</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 text-amber-500 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('rekomendasi.proses-perhitungan') }}" class="hover:text-amber-600 transition-colors">Proses Perhitungan</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 text-amber-500 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-gray-400">Detail Perhitungan</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex gap-2">
            <a href="javascript:history.back()" class="inline-flex items-center text-xs font-bold text-amber-900 bg-white border border-amber-200 px-3 py-1.5 rounded-lg hover:bg-amber-50 transition-all shadow-sm">
                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <a href="{{ route('rekomendasi.proses-perhitungan') }}" class="inline-flex items-center text-xs font-bold text-indigo-900 bg-indigo-50 border border-indigo-200 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition-all shadow-sm">
                Lihat Matriks Perbandingan
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="glass-card rounded-[24px] p-6 sm:p-8 mb-6">
        
        <!-- Header Info Kost -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-amber-100">
            <div>
                <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] uppercase font-extrabold tracking-wider bg-indigo-50 text-indigo-700 mb-2">
                    Ranking #{{ $rank }} Terbaik
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight leading-none mb-1.5">{{ $kost->nama_kost }}</h1>
                <p class="text-xs text-gray-500 font-semibold flex items-center">
                    <svg class="w-4 h-4 mr-1 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $kost->alamat }}
                </p>
            </div>
            
            <!-- Radial Match Score Card -->
            <div class="flex items-center gap-4 bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100/50 p-4 rounded-2xl shadow-inner min-w-[200px]">
                <div class="flex-1">
                    <p class="text-[10px] text-indigo-400 font-bold uppercase tracking-wider mb-0.5">Persentase Kecocokan</p>
                    <p class="text-3xl font-black text-indigo-950 leading-none">{{ $kost->persentase }}%</p>
                    <p class="text-[10px] text-indigo-600 font-extrabold mt-1 uppercase tracking-wide">Skor: {{ number_format($kost->skor_total, 2) }} / 10.0</p>
                </div>
                <div class="w-12 h-12 rounded-full {{ $kost->persentase >= 70 ? 'bg-indigo-600 text-white' : ($kost->persentase >= 50 ? 'bg-amber-500 text-white' : 'bg-red-500 text-white') }} flex items-center justify-center font-black text-sm">
                    @if($kost->persentase >= 70) 👍 @elseif($kost->persentase >= 50) ⚡ @else ❌ @endif
                </div>
            </div>
        </div>

        <!-- Rule Evaluation Details -->
        <div class="mt-8">
            <h3 class="text-sm font-extrabold text-amber-950 uppercase tracking-widest mb-6">Detail Hasil Evaluasi Aturan (Rule-Based )</h3>
            
            <div class="space-y-6">
                @foreach($kost->detail_perhitungan as $key => $rule)
                <div class="bg-gray-50 border border-gray-150 rounded-2xl p-5 hover:border-amber-200 transition-colors shadow-sm">
                    <!-- Rule Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-black {{ $rule['is_match'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {!! $rule['is_match'] ? '&#10003;' : '&#10007;' !!}
                            </span>
                            <div>
                                <h4 class="text-sm font-extrabold text-gray-900">{{ $rule['nama'] }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Bobot Kriteria: {{ number_format($rule['bobot'], 1) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wide {{ $rule['is_match'] ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ $rule['is_match'] ? 'Aturan Terpenuhi' : 'Aturan Tidak Terpenuhi' }}
                            </span>
                            <span class="inline-block px-3 py-1 bg-white border border-gray-200 text-xs font-black text-gray-800 rounded-lg">
                                Skor: {{ number_format($rule['skor'], 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Comparison Box -->
                    <div class="grid grid-cols-2 gap-4 bg-white border border-gray-100 rounded-xl p-3 mb-3 text-xs">
                        <div>
                            <span class="block text-[9px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Preferensi Pengguna</span>
                            <span class="font-extrabold text-gray-800">{{ $rule['input_user'] }}</span>
                        </div>
                        <div>
                            <span class="block text-[9px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Kondisi Kost Nyata</span>
                            <span class="font-extrabold text-gray-800">{{ $rule['nilai_kost'] }}</span>
                        </div>
                    </div>

                    <!-- Explanation -->
                    <p class="text-xs text-gray-600 leading-relaxed font-semibold">
                        <span class="text-amber-800">Analisis:</span> {{ $rule['penjelasan'] }}.
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Academic Conclusion -->
        <div class="mt-8 p-5 rounded-2xl bg-indigo-50/50 border border-indigo-100 text-xs text-indigo-950 font-semibold leading-relaxed">
            <h4 class="text-xs font-extrabold text-indigo-900 uppercase tracking-widest mb-2">Kesimpulan Analitis Rekomendasi (Skripsi)</h4>
            <p>
                Berdasarkan evaluasi aturan menggunakan model *Knowledge-Based Recommendation*, kost <strong>{{ $kost->nama_kost }}</strong> mendapatkan skor kesesuaian sebesar <strong>{{ number_format($kost->skor_total, 2) }} dari 10.0 (Kesesuaian {{ $kost->persentase }}%)</strong>. 
                Kost ini menempati peringkat ke-{{ $rank }} dalam sistem.
                @if($kost->persentase >= 80)
                    Kost ini memiliki tingkat kesesuaian yang sangat tinggi (Highly Recommended) terhadap kriteria yang Anda cari, terutama karena memenuhi kriteria krusial (harga dan jarak) secara penuh serta memiliki fasilitas yang relevan.
                @elseif($kost->persentase >= 50)
                    Kost ini direkomendasikan sebagai opsi alternatif yang baik (Recommended), karena sebagian besar kriteria yang Anda cari terpenuhi dengan baik.
                @else
                    Kost ini dikategorikan memiliki kecocokan yang rendah terhadap preferensi Anda, namun dapat dijadikan opsi sekunder jika kriteria utama Anda dilonggarkan.
                @endif
            </p>
        </div>

        <!-- Footer Action -->
        <div class="mt-8 pt-6 border-t border-amber-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="javascript:history.back()" class="text-xs font-extrabold text-amber-800 hover:text-amber-600 transition-colors">
                &larr; Kembali ke halaman hasil pencarian
            </a>
            
            <a href="https://wa.me/{{ $kost->no_hp }}?text=Halo%2C%20saya%20mendapat%20rekomendasi%20dari%20Sistem%20Kost%20Pare.%20Apakah%20{{ urlencode($kost->nama_kost) }}%20masih%20tersedia%3F" target="_blank"
                class="flex items-center justify-center px-6 py-3 border border-transparent rounded-xl text-xs font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:opacity-90 hover:-translate-y-0.5 transition-all shadow-lg shadow-indigo-200">
                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.423 2.296 1.054 3.091l-.988 2.923 3.011-.979c.84.444 1.839.73 2.69.73 3.181 0 5.768-2.587 5.768-5.766 0-3.18-2.587-5.765-5.767-5.765zm0 10.375c-.878 0-1.745-.236-2.495-.683l-.178-.106-1.854.603.613-1.808-.117-.186c-.496-.788-.758-1.705-.758-2.666 0-2.553 2.077-4.631 4.63-4.631 2.554 0 4.632 2.078 4.632 4.631 0 2.553-2.078 4.631-4.632 4.631zm2.535-3.468c-.138-.069-.824-.407-.952-.454-.128-.046-.221-.069-.314.069-.093.138-.36.454-.442.547-.082.093-.163.104-.301.035-.138-.07-.589-.217-1.121-.692-.416-.372-.697-.833-.779-.972-.081-.138-.009-.214.06-.283.064-.064.138-.162.208-.243.069-.081.093-.138.138-.23.047-.093.024-.174-.011-.244-.035-.07-.315-.758-.431-1.037-.113-.272-.228-.236-.314-.241-.082-.004-.176-.004-.269-.004-.093 0-.244.035-.373.174-.128.138-.49.477-.49 1.164 0 .686.501 1.349.571 1.442.069.093.985 1.5 2.385 2.105.333.14.593.224.796.287.334.106.638.09.878.055.268-.04.824-.337.939-.663.116-.326.116-.605.081-.663-.034-.059-.127-.094-.265-.163z"/></svg>
                Hubungi via WhatsApp
            </a>
        </div>

    </div>
</div>
@endsection
