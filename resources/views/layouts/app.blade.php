<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KostPare – Sistem Rekomendasi Kost Pare</title>
    <meta name="description" content="Temukan kost terbaik di Kampung Inggris Pare sesuai budget, lokasi, dan fasilitas yang Anda butuhkan.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .brand-gradient {
            background: linear-gradient(135deg, #b45309 0%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white/95 backdrop-blur-md shadow-sm border-b border-amber-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-1.5">
                        <div class="w-7 h-7 bg-gradient-to-br from-amber-600 to-orange-500 rounded-lg flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="text-xl font-extrabold tracking-tight brand-gradient">KostPare</span>
                    </a>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-amber-700 font-semibold transition-colors px-3 py-1.5 rounded-lg hover:bg-amber-50">Cari Kost</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-amber-100 py-5">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-gray-400 font-medium">
            &copy; {{ date('Y') }} <span class="font-semibold text-amber-600">KostPare</span> — Sistem Rekomendasi Kost Kampung Inggris Pare
        </div>
    </footer>

</body>
</html>
