<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recehan - Aplikasi Keuangan Sederhana</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-500 selection:text-white min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-1.5 sm:gap-2">
                <span class="text-xl sm:text-2xl font-bold text-emerald-600 tracking-tight">💴 Recehan.</span>
                <span class="text-[10px] sm:text-xs bg-emerald-100 text-emerald-800 font-medium px-2 py-0.5 rounded-full whitespace-nowrap">Web & Mobile</span>
            </div>

            <!-- Navigasi (Hanya Home & Login) -->
            <nav class="flex items-center gap-4 sm:gap-6">
                <a href="/" class="text-xs sm:text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                    Home
                </a>
                <a href="{{ url('/dasbor') }}" class="text-xs sm:text-sm font-semibold bg-emerald-600 text-white px-4 sm:px-5 py-2 rounded-xl hover:bg-emerald-700 shadow-sm shadow-emerald-600/20 transition-all">
                    Login
                </a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-20 grow flex items-center">
        <!-- Hero Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center w-full">
            
            <!-- Teks Utama -->
            <div class="space-y-4 sm:space-y-6 text-center lg:text-left order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 text-[11px] sm:text-xs font-medium px-3 py-1.5 rounded-full">
                    <span>📱 Android, iOS, dan Web Browser</span>
                </div>
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-bold text-slate-900 tracking-tight leading-tight">
                    Kelola uang <span class="text-emerald-600">receh</span> jadi lebih bermakna.
                </h1>
                <p class="text-sm sm:text-lg text-slate-600 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                    Catat pengeluaran harian, pantau tabungan, dan kendalikan keuanganmu dalam satu aplikasi sederhana. Ringan diakses di HP maupun Laptop.
                </p>
                <div class="pt-2 flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ url('/dasbor') }}" class="bg-slate-900 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-slate-800 transition-all text-center text-sm sm:text-base">
                        Mulai Catat Sekarang
                    </a>
                </div>
            </div>

            <!-- Ilustrasi / Visual Sederhana (Mockup UI) -->
            <div class="relative flex justify-center lg:justify-end order-1 lg:order-2 w-full max-w-md mx-auto lg:max-w-none">
                <!-- Background dekoratif -->
                <div class="absolute inset-0 bg-linear-to-tr from-emerald-200 to-teal-100 rounded-3xl filter blur-3xl opacity-30 -z-10 transform scale-95"></div>
                
                <!-- Box simulasi tampilan UI Aplikasi (Sekarang Full Responsive) -->
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-xl border border-slate-100 w-full space-y-4 sm:space-y-6 transform hover:scale-[1.01] transition-transform duration-300">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                        <div>
                            <p class="text-[10px] sm:text-xs text-slate-400 font-medium">Total Saldo Kamu</p>
                            <h3 class="text-xl sm:text-2xl font-bold text-slate-800">Rp 750.000</h3>
                        </div>
                        <span class="bg-emerald-50 text-emerald-700 text-[10px] sm:text-xs font-bold px-2 py-1 rounded-lg">+12%</span>
                    </div>
                    
                    <!-- List Transaksi -->
                    <div class="space-y-3">
                        <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Transaksi Terakhir</p>
                        
                        <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold shrink-0">☕</div>
                                <div class="truncate">
                                    <p class="text-xs sm:text-sm font-semibold text-slate-700 truncate">Kopi Susu Senja</p>
                                    <p class="text-[10px] sm:text-xs text-slate-400">Hari ini, 14:20</p>
                                </div>
                            </div>
                            <span class="text-xs sm:text-sm font-bold text-rose-600 shrink-0 ml-2">- Rp 25.000</span>
                        </div>

                        <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold shrink-0">💸</div>
                                <div class="truncate">
                                    <p class="text-xs sm:text-sm font-semibold text-slate-700 truncate">Transferan Dari Ayank</p>
                                    <p class="text-[10px] sm:text-xs text-slate-400">Kemarin, 19:00</p>
                                </div>
                            </div>
                            <span class="text-xs sm:text-sm font-bold text-emerald-600 shrink-0 ml-2">+ Rp 500.000</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer Ringkas -->
    <footer class="border-t border-slate-100 bg-white py-4 w-full">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs sm:text-sm text-slate-400">
            &copy; {{ date('Y') }} Recehan by Betta Wahyu. Hak Cipta Tidak Dilindungi.
        </div>
    </footer>

</body>
</html>