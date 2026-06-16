<div class="group relative w-[280px] sm:w-[320px] h-full flex flex-col bg-white rounded-[20px] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden border {{ $isAlternatif ? 'border-gray-200' : 'border-gray-100' }} cursor-pointer">

    <!-- Top Image Section -->
    <div class="relative aspect-[4/3] w-full overflow-hidden flex-shrink-0">
        @if($kost->foto)
            <img src="{{ asset('storage/' . $kost->foto) }}" alt="Foto {{ $kost->nama_kost }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-gradient-to-br from-indigo-50 to-purple-50 flex flex-col items-center justify-center text-indigo-200 group-hover:from-indigo-100 transition-colors">
                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-xs font-medium text-indigo-300">Tanpa Foto</span>
            </div>
        @endif

        <!-- Rank Badge Overlay -->
        <div class="absolute top-3 left-3 flex flex-col gap-1.5 items-start">
            @if(!$isAlternatif && isset($rank))
                @if($rank === 1)
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-[10px] font-extrabold px-3 py-1 rounded-full shadow-lg flex items-center uppercase tracking-wide">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Best Match
                    </div>
                @elseif($rank === 2)
                    <div class="bg-indigo-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-full shadow-lg flex items-center uppercase tracking-wide">
                        #2 Terbaik
                    </div>
                @elseif($rank === 3)
                    <div class="bg-violet-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-full shadow-lg flex items-center uppercase tracking-wide">
                        #3 Pilihan
                    </div>
                @endif
            @endif

            @if($kost->persentase >= 80)
                <div class="bg-amber-400 text-amber-900 text-[10px] font-extrabold px-3 py-1 rounded-full shadow-lg flex items-center uppercase tracking-wide">
                    ⚡ Highly Recommended
                </div>
            @endif
        </div>

        <!-- Tipe Kost Overlay -->
        <div class="absolute bottom-3 left-3 flex gap-2">
            <span class="bg-white/90 backdrop-blur-sm text-gray-800 text-[10px] font-bold px-2 py-1 rounded-md shadow-sm uppercase tracking-wide">
                {{ $kost->jenis_kost }}
            </span>
            @if($isAlternatif || $kost->status === 'penuh')
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-sm uppercase tracking-wide">Penuh</span>
            @endif
        </div>
    </div>

    <!-- Content Section -->
    <div class="p-4 sm:p-5 flex flex-col flex-1">
        <div class="flex justify-between items-start mb-1">
            <h4 class="text-lg font-bold text-gray-900 line-clamp-1 leading-tight group-hover:text-indigo-600 transition-colors">{{ $kost->nama_kost }}</h4>
        </div>

        <p class="text-[11px] font-medium text-gray-500 flex items-center mb-3">
            <svg class="w-3.5 h-3.5 mr-1 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            {{ $kost->jarak }} Meter dari kursus
        </p>

        <!-- Facilities tags -->
        <div class="flex flex-wrap gap-1.5 mb-4 max-h-[44px] overflow-hidden">
            @foreach(array_slice($kost->fasilitas->toArray(), 0, 3) as $f)
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-600 border border-indigo-100">
                    {{ $f['nama_fasilitas'] }}
                </span>
            @endforeach
            @if(count($kost->fasilitas) > 3)
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold bg-gray-50 text-gray-500 border border-gray-100">
                    +{{ count($kost->fasilitas) - 3 }}
                </span>
            @endif
        </div>

        <div class="mt-auto pt-3 border-t border-gray-100">
            <!-- Price and Score -->
            <div class="flex justify-between items-end mb-3">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-0.5">Mulai dari</p>
                    <p class="text-lg font-extrabold text-gray-900 leading-none">Rp{{ number_format($kost->harga, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-0.5">Kecocokan</p>
                    <p class="text-sm font-black {{ $kost->persentase >= 70 ? 'text-indigo-600' : ($kost->persentase >= 50 ? 'text-amber-500' : 'text-rose-500') }} leading-none">
                        {{ $kost->persentase }}%
                    </p>
                </div>
            </div>

            <!-- Score Progress Bar -->
            <div class="w-full bg-gray-100 rounded-full h-1.5 mb-3">
                <div class="h-1.5 rounded-full {{ $kost->persentase >= 70 ? 'bg-gradient-to-r from-indigo-500 to-purple-500' : ($kost->persentase >= 50 ? 'bg-amber-400' : 'bg-rose-400') }} transition-all duration-500"
                    style="width: {{ $kost->persentase }}%"></div>
            </div>

            <!-- Explanation Dropdown -->
            @if(isset($kost->alasan_rekomendasi) && count($kost->alasan_rekomendasi) > 0)
            <div class="mb-3">
                <details class="group/details bg-gray-50 rounded-lg border border-gray-100 overflow-hidden open:shadow-sm transition-all duration-300">
                    <summary class="text-[11px] font-bold text-gray-600 cursor-pointer p-2 flex justify-between items-center hover:bg-indigo-50 hover:text-indigo-700 transition-colors list-none">
                        <span>Kenapa direkomendasikan?</span>
                        <svg class="w-3.5 h-3.5 text-gray-400 group-open/details:rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <div class="p-2.5 pt-0 text-[11px] text-gray-500 bg-gray-50">
                        <ul class="list-disc pl-4 space-y-1 mt-1">
                            @foreach($kost->alasan_rekomendasi as $alasan)
                                <li>{{ $alasan }}</li>
                            @endforeach
                        </ul>
                    </div>
                </details>
                <style>details > summary::-webkit-details-marker { display: none; }</style>
            </div>
            @endif

            <!-- Action (WhatsApp & Detail Hitung) -->
            <div class="grid grid-cols-2 gap-2 mt-auto">
                <a href="{{ route('rekomendasi.detail', $kost->id) }}"
                    class="flex items-center justify-center px-3 py-2 border border-indigo-200 rounded-xl text-[11px] font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 hover:-translate-y-0.5 transition-all shadow-sm">
                    Detail Hitung
                </a>
                <a href="https://wa.me/{{ $kost->no_hp }}?text=Halo%2C%20saya%20mendapat%20rekomendasi%20dari%20Sistem%20Kost%20Pare.%20Apakah%20{{ urlencode($kost->nama_kost) }}%20masih%20tersedia%3F" target="_blank"
                    class="flex items-center justify-center px-3 py-2 border border-transparent rounded-xl text-[11px] font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:opacity-90 hover:-translate-y-0.5 transition-all shadow-sm shadow-indigo-200">
                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.423 2.296 1.054 3.091l-.988 2.923 3.011-.979c.84.444 1.839.73 2.69.73 3.181 0 5.768-2.587 5.768-5.766 0-3.18-2.587-5.765-5.767-5.765zm0 10.375c-.878 0-1.745-.236-2.495-.683l-.178-.106-1.854.603.613-1.808-.117-.186c-.496-.788-.758-1.705-.758-2.666 0-2.553 2.077-4.631 4.63-4.631 2.554 0 4.632 2.078 4.632 4.631 0 2.553-2.078 4.631-4.632 4.631zm2.535-3.468c-.138-.069-.824-.407-.952-.454-.128-.046-.221-.069-.314.069-.093.138-.36.454-.442.547-.082.093-.163.104-.301.035-.138-.07-.589-.217-1.121-.692-.416-.372-.697-.833-.779-.972-.081-.138-.009-.214.06-.283.064-.064.138-.162.208-.243.069-.081.093-.138.138-.23.047-.093.024-.174-.011-.244-.035-.07-.315-.758-.431-1.037-.113-.272-.228-.236-.314-.241-.082-.004-.176-.004-.269-.004-.093 0-.244.035-.373.174-.128.138-.49.477-.49 1.164 0 .686.501 1.349.571 1.442.069.093.985 1.5 2.385 2.105.333.14.593.224.796.287.334.106.638.09.878.055.268-.04.824-.337.939-.663.116-.326.116-.605.081-.663-.034-.059-.127-.094-.265-.163z"/></svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
