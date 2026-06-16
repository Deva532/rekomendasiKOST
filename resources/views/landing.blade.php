<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekomendasi Kost</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .bg-cream { background-color: #fdfaf6; }
        .text-dark-green { color: #1a3629; }
        .bg-dark-green { background-color: #1a3629; }
        .text-gold { color: #c2a265; }
        .border-gold { border-color: #c2a265; }
        .hover-bg-dark-green-light:hover { background-color: #244a39; }
    </style>
</head>
<body class="bg-cream text-gray-800 antialiased overflow-x-hidden">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left Column (Content) -->
        <div class="flex-1 flex flex-col justify-center px-8 sm:px-16 lg:px-24 xl:px-32 py-12 lg:py-0 z-10 relative bg-cream">
            <!-- Decorative accent behind content -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 opacity-30 pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full border border-gold opacity-20"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[300px] h-[300px] rounded-full border border-[#1a3629] opacity-10"></div>
            </div>

            <!-- Logo Area -->
            <div class="flex items-center space-x-3 mb-16">
                <div class="w-12 h-12 rounded-full bg-dark-green flex items-center justify-center text-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold tracking-widest text-dark-green uppercase">Sistem Rekomendasi</h2>
                    <p class="text-xs text-gold font-medium">Kost Pare</p>
                </div>
            </div>

            <!-- Main Content -->
            <div class="max-w-xl">
                <div class="flex items-center space-x-4 mb-4">
                    <span class="h-px w-12 bg-gold"></span>
                    <span class="text-gold font-medium uppercase tracking-wider text-sm">Selamat Datang</span>
                </div>
                
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-serif font-bold text-dark-green leading-tight mb-6">
                    SISTEM<br>
                    REKOMENDASI<br>
                    KOST
                </h1>
                
                <h3 class="text-xl sm:text-2xl text-gray-700 font-medium mb-6 leading-relaxed">
                    Temukan Kost Ideal Sesuai Preferensimu.
                </h3>
                
                <p class="text-gray-500 text-lg mb-10 leading-relaxed max-w-lg">
                    Kami membantumu menemukan kost yang paling sesuai dengan kebutuhan dan preferensimu dengan rekomendasi yang personal.
                </p>
                
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-medium text-white bg-dark-green hover-bg-dark-green-light rounded-full shadow-lg shadow-dark-green/30 transition-all duration-300 transform hover:-translate-y-1 group">
                    <span>Cari Kost Sekarang</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Right Column (Image) -->
        <div class="flex-1 relative lg:block w-full min-h-[50vh] lg:min-h-screen">
            <div class="absolute inset-0 bg-dark-green/10 mix-blend-multiply z-10 pointer-events-none"></div>
            <!-- Overlay gradient for smooth transition on desktop -->
            <div class="hidden lg:block absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-cream to-transparent z-10 pointer-events-none"></div>
            <!-- Overlay gradient for mobile -->
            <div class="lg:hidden absolute top-0 inset-x-0 h-32 bg-gradient-to-b from-cream to-transparent z-10 pointer-events-none"></div>
            <img src="{{ asset('images/hero-kost.png') }}" alt="Kamar Kost Modern" class="absolute inset-0 w-full h-full object-cover object-center shadow-2xl">
        </div>
    </div>
</body>
</html>
