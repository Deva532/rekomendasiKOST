@extends('layouts.app')

@section('content')
<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; scroll-behavior: smooth; }
    .fade-enter { animation: fadeIn 0.4s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="max-w-7xl mx-auto px-0 sm:px-6 lg:px-8 py-6 sm:py-10 min-h-[calc(100vh-3.5rem-3.25rem)]">

    <!-- Header -->
    <div class="px-5 sm:px-0 mb-6 sm:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 fade-enter">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Rekomendasi Kost Untukmu</h2>
            <p class="mt-1 text-sm font-medium text-gray-500">Geser ke samping untuk melihat kost terbaik sesuai preferensi Anda.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('rekomendasi.proses-perhitungan') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-full transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                Proses Perhitungan
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 hover:text-indigo-700 text-gray-700 text-sm font-bold rounded-full transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Ubah Filter
            </a>
        </div>
    </div>

    <!-- SKELETON LOADING STATE -->
    <div id="skeleton-container" class="mb-10 px-5 sm:px-0 block">
        <div class="flex overflow-x-hidden gap-5 pb-8 pt-2">
            @for ($i = 0; $i < 3; $i++)
            <div class="w-[280px] sm:w-[320px] shrink-0 bg-white rounded-[20px] border border-gray-100 shadow-sm animate-pulse">
                <div class="w-full aspect-[4/3] bg-gray-200 rounded-t-[20px]"></div>
                <div class="p-5">
                    <div class="h-5 bg-gray-200 rounded-md w-3/4 mb-4"></div>
                    <div class="h-3 bg-gray-200 rounded-md w-1/2 mb-4"></div>
                    <div class="flex gap-2 mb-6">
                        <div class="h-6 bg-gray-200 rounded-full w-12"></div>
                        <div class="h-6 bg-gray-200 rounded-full w-12"></div>
                        <div class="h-6 bg-gray-200 rounded-full w-12"></div>
                    </div>
                    <div class="flex justify-between items-end mb-4">
                        <div class="h-6 bg-gray-200 rounded-md w-24"></div>
                        <div class="h-6 bg-gray-200 rounded-md w-12"></div>
                    </div>
                    <div class="h-10 bg-gray-200 rounded-xl w-full"></div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- ACTUAL CONTENT (Hidden initially) -->
    <div id="content-container" class="hidden fade-enter">
        <!-- Recommendations Carousel -->
        <div class="mb-12">
            @if(count($utama) > 0)
                <div class="flex overflow-x-auto snap-x snap-mandatory gap-5 pb-8 pt-2 px-5 sm:px-0 hide-scrollbar scroll-smooth">
                    @foreach($utama as $index => $kost)
                        <div class="snap-start shrink-0">
                            @include('components.kost-card', ['kost' => $kost, 'isAlternatif' => false, 'rank' => $index + 1])
                        </div>
                    @endforeach
                    <div class="snap-start shrink-0 w-2 sm:hidden"></div>
                </div>
            @else
                <!-- EMPTY STATE -->
                <div class="px-5 sm:px-0">
                    <div class="bg-white border border-gray-200 p-8 sm:p-12 rounded-[24px] shadow-sm flex flex-col items-center text-center max-w-2xl mx-auto">
                        <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="h-10 w-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-xl font-extrabold text-gray-900 mb-2">Kost Tidak Ditemukan</h4>
                        <p class="text-gray-500 mb-8 max-w-md">Kami tidak dapat menemukan kost yang sesuai dengan filter harga, jarak, dan tipe kost yang Anda pilih.</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:opacity-90 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-200">
                            Coba Ubah Filter
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Alternative (Penuh tapi cocok) -->
        @if(count($alternatif) > 0)
            <div class="mt-8">
                <div class="px-5 sm:px-0 mb-5">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                        <h3 class="text-xl font-extrabold text-gray-900">Alternatif Jika Kost Penuh</h3>
                    </div>
                    <p class="text-sm font-medium text-gray-500 ml-5">Kost di bawah ini sangat cocok dengan kriteria Anda, namun status kamarnya sedang penuh.</p>
                </div>

                <div class="flex overflow-x-auto snap-x snap-mandatory gap-5 pb-8 pt-2 px-5 sm:px-0 hide-scrollbar opacity-80 hover:opacity-100 transition-opacity duration-300">
                    @foreach($alternatif as $index => $kost)
                        <div class="snap-start shrink-0 grayscale hover:grayscale-0 transition-all duration-500">
                            @include('components.kost-card', ['kost' => $kost, 'isAlternatif' => true, 'rank' => null])
                        </div>
                    @endforeach
                    <div class="snap-start shrink-0 w-2 sm:hidden"></div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    // Simulate network loading state for smooth UX
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(() => {
            document.getElementById('skeleton-container').style.display = 'none';
            document.getElementById('content-container').classList.remove('hidden');
        }, 600);
    });
</script>
@endsection
