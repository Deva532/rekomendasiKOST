@extends('layouts.app')

@section('content')
<style>
    /* Design System — Cream / Warm Neutral */
    .bg-primary-gradient { background: linear-gradient(135deg, #b45309 0%, #d97706 100%); }
    .bg-cream-hero { background: linear-gradient(160deg, #fef3c7 0%, #fde68a 40%, #fef9f0 100%); }

    .glass-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(254, 243, 199, 0.8);
        box-shadow: 0 20px 60px rgba(180, 83, 9, 0.12);
    }

    /* Focus states — warm amber */
    .field-input:focus {
        border-color: #d97706 !important;
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.12);
        background: white;
        outline: none;
    }
    .field-input:hover { border-color: #fcd34d; }

    /* Chip checkbox — cream/amber */
    .chip-label input:checked ~ .chip-body {
        border-color: #d97706;
        background: #fef3c7;
        color: #92400e;
    }
    .chip-body { transition: all 0.15s ease; }

    /* Animation */
    .fade-up { animation: fadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Scrollbar hide */
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Submit button */
    .btn-primary {
        background: linear-gradient(135deg, #b45309 0%, #d97706 100%);
        box-shadow: 0 4px 14px rgba(180, 83, 9, 0.35);
    }
    .btn-primary:hover { opacity: 0.92; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(180, 83, 9, 0.4); }
</style>

<!-- Full Screen Hero -->
<div class="relative w-full h-[calc(100vh-3.5rem)] flex items-center justify-center overflow-hidden bg-cream-hero">

    <!-- Background Decoratives -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <!-- Warm cream blob top left -->
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-amber-200 rounded-full filter blur-3xl opacity-50"></div>
        <!-- Warm blob top right -->
        <div class="absolute -top-10 -right-10 w-80 h-80 bg-yellow-200 rounded-full filter blur-3xl opacity-60" style="animation-delay:1.5s;"></div>
        <!-- Bottom accent -->
        <div class="absolute bottom-0 left-1/4 w-72 h-72 bg-orange-100 rounded-full filter blur-3xl opacity-40"></div>
        <!-- Subtle pattern overlay -->
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(180,83,9,0.06) 1px, transparent 0); background-size: 32px 32px;"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 w-full max-w-2xl px-4 sm:px-6 flex flex-col items-center fade-up">

        <!-- Hero Text (compact) -->
        <div class="text-center mb-6">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-amber-900 tracking-tight leading-tight mb-2">
                Temukan Kost Idealmu
            </h1>
            <p class="text-amber-700 text-sm sm:text-base font-medium max-w-lg mx-auto">
                Sesuaikan budget &amp; preferensi — sistem kami carikan kost terbaik di Pare untuk Anda.
            </p>
        </div>

        <!-- Card Form -->
        <div class="w-full glass-card rounded-2xl overflow-hidden">
            <form action="{{ route('proses') }}" method="POST" class="p-5 sm:p-6" id="form-preferensi">
                @csrf

                <div class="space-y-4">
                    <!-- 2 Columns: Harga & Jarak -->
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Harga -->
                        <div>
                            <label for="harga_max" class="block text-xs font-bold text-amber-800 mb-1.5 uppercase tracking-wider">Harga Maksimal</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-amber-600 font-semibold text-sm">Rp</span>
                                </div>
                                <input type="number" name="harga_max" id="harga_max" required
                                    class="field-input block w-full pl-10 pr-3 py-2.5 bg-amber-50/60 border border-amber-200 rounded-xl transition-all text-sm font-bold text-gray-900 placeholder-amber-300"
                                    placeholder="500.000" value="500000">
                            </div>
                        </div>

                        <!-- Jarak -->
                        <div>
                            <label for="jarak_max" class="block text-xs font-bold text-amber-800 mb-1.5 uppercase tracking-wider">Jarak Maks.</label>
                            <div class="relative">
                                <input type="number" name="jarak_max" id="jarak_max" required
                                    class="field-input block w-full pl-3 pr-10 py-2.5 bg-amber-50/60 border border-amber-200 rounded-xl transition-all text-sm font-bold text-gray-900 placeholder-amber-300"
                                    placeholder="1000" value="1000">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-amber-500 text-xs font-semibold">m</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Kost -->
                    <div>
                        <label for="jenis_kost" class="block text-xs font-bold text-amber-800 mb-1.5 uppercase tracking-wider">Jenis Kost</label>
                        <div class="relative">
                            <select id="jenis_kost" name="jenis_kost"
                                class="field-input appearance-none block w-full pl-3 pr-10 py-2.5 bg-amber-50/60 border border-amber-200 rounded-xl transition-all text-sm font-bold text-gray-900 cursor-pointer">
                                <option value="putra">🧑 Putra</option>
                                <option value="putri">👩 Putri</option>
                                <option value="campur">👥 Campur (Putra & Putri)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-amber-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Fasilitas Chips -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold text-amber-800 uppercase tracking-wider">Fasilitas</label>
                            <span class="text-[10px] font-medium text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full">Pilih lebih dari satu</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5 max-h-[80px] overflow-y-auto hide-scrollbar">
                            @foreach ($fasilitas as $f)
                            <label class="chip-label relative cursor-pointer">
                                <input id="fasilitas_{{ $f->id }}" name="fasilitas[]" value="{{ $f->id }}" type="checkbox" class="sr-only">
                                <div class="chip-body inline-flex items-center px-3 py-1 rounded-full border border-amber-200 bg-white text-xs font-semibold text-gray-600 hover:border-amber-400 hover:bg-amber-50 shadow-sm">
                                    {{ $f->nama_fasilitas }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-5">
                    <button type="submit"
                        class="btn-primary w-full flex justify-center items-center gap-2 py-3 px-4 rounded-xl text-sm font-bold text-white transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-amber-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari Rekomendasi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Trust indicators -->
        <div class="flex items-center gap-4 mt-4 text-xs text-amber-700/80 font-medium">
            <div class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Gratis & Terpercaya
            </div>
            <div class="w-1 h-1 bg-amber-400 rounded-full"></div>
            <div class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                Kost Pare
            </div>
        </div>

    </div>
</div>

<script>
// Chip toggle visual feedback
document.querySelectorAll('.chip-label input[type="checkbox"]').forEach(cb => {
    cb.addEventListener('change', function() {
        const body = this.nextElementSibling;
        if (this.checked) {
            body.classList.add('border-amber-500', 'bg-amber-50', 'text-amber-800');
            body.classList.remove('border-amber-200', 'bg-white', 'text-gray-600');
        } else {
            body.classList.remove('border-amber-500', 'bg-amber-50', 'text-amber-800');
            body.classList.add('border-amber-200', 'bg-white', 'text-gray-600');
        }
    });
});
</script>
@endsection
