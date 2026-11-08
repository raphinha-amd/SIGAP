<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP - Sistem Informasi Aspirasi dan Pengaduan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- FontAwesome for modern icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased font-sans selection:bg-indigo-500 selection:text-white">

    <!-- Notification Banner (Custom Message Box Replacement) -->
    <div id="toast"
        class="fixed top-5 right-5 z-50 transform translate-x-full transition-all duration-300 ease-in-out bg-white border border-slate-200 shadow-xl rounded-xl p-4 flex items-center space-x-3 hidden">
        <div
            class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-check"></i>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-slate-900" id="toast-title">Informasi</h4>
        </div>
    </div>

    <!-- 1. NAVBAR -->
    <header
        class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200 transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Logo -->
            <a href="#" class="flex items-center space-x-3 group">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-800 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-bullhorn text-lg"></i>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-tight text-slate-900">SIG<span
                            class="text-indigo-600">AP</span></span>
                    <span class="block text-[10px] uppercase tracking-wider text-slate-500 font-medium">Aspirasi &
                        Pengaduan</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#beranda"
                    class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">Beranda</a>
                <a href="#fitur"
                    class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">Fitur</a>
                <a href="#alur"
                    class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">Alur
                    Pengaduan</a>
                <a href="#faq"
                    class="text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">FAQ</a>
            </nav>

            <!-- CTA Button Desktop -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="/masyarakat/login"
                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-600/25 hover:shadow-indigo-600/40 transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk / Login
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn"
                class="md:hidden text-slate-700 hover:text-indigo-600 focus:outline-none p-2 rounded-lg">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu Drawer -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-3">
            <a href="#beranda" class="block py-2 text-base font-medium text-slate-700 hover:text-indigo-600">Beranda</a>
            <a href="#fitur" class="block py-2 text-base font-medium text-slate-700 hover:text-indigo-600">Fitur</a>
            <a href="#alur" class="block py-2 text-base font-medium text-slate-700 hover:text-indigo-600">Alur
                Pengaduan</a>
            <a href="#faq" class="block py-2 text-base font-medium text-slate-700 hover:text-indigo-600">FAQ</a>
            <div class="pt-2">
                <a href="/masyarakat/login"
                    class="w-full flex items-center justify-center px-5 py-3 rounded-xl text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk / Login
                </a>
            </div>
        </div>
    </header>

    <!-- 2. HERO SECTION -->
    <section id="beranda"
        class="relative overflow-hidden pt-16 pb-24 lg:pt-24 lg:pb-32 bg-gradient-to-b from-indigo-50/50 via-white to-slate-50">
        <!-- Background Decorative Blur -->
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-r from-indigo-200/30 to-blue-200/30 blur-3xl -z-10 rounded-full pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Content -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div
                        class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold tracking-wide uppercase">
                        <span class="flex h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        <span>Sistem Layanan Publik Terintegrasi</span>
                    </div>
                    <h1
                        class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                        Suara Anda, <br class="hidden sm:inline"><span
                            class="bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">Kunci
                            Perubahan</span> Publik
                    </h1>
                    <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                        Platform pengaduan dan aspirasi masyarakat berbasis digital. Dibangun dengan teknologi modern
                        Laravel & Filament untuk memastikan transparansi, kecepatan respons, dan kenyamanan Anda.
                    </p>
                    <div
                        class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                        <a href="/masyarakat/login"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-4 rounded-xl text-base font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-xl shadow-indigo-600/30 hover:shadow-indigo-600/50 transition-all duration-200 transform hover:-translate-y-0.5">
                            <span>Laporkan Aspirasi</span>
                            <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                        </a>
                        <a href="/masyarakat/login"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-4 rounded-xl text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 shadow-sm hover:shadow transition-all duration-200">
                            <i class="fa-solid fa-user-circle mr-2 text-indigo-600"></i> Masuk ke Akun
                        </a>
                    </div>
                    <!-- Quick stats / trust badge -->
                    <div class="pt-8 border-t border-slate-200/80 grid grid-cols-3 gap-4 max-w-lg mx-auto lg:mx-0">
                        <div>
                            <p class="text-2xl font-bold text-slate-900">100%</p>
                            <p class="text-xs text-slate-500 font-medium">Transparan</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">&lt; 24 Jam</p>
                            <p class="text-xs text-slate-500 font-medium">Respon Cepat</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">Aman</p>
                            <p class="text-xs text-slate-500 font-medium">Verifikasi NIK</p>
                        </div>
                    </div>
                </div>

                <!-- Right Illustration / Card Preview -->
                <div class="lg:col-span-5">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <!-- Card Mockup -->
                        <div
                            class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xl shadow-indigo-500/10 border border-slate-100 relative z-10 space-y-6">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900">Portal Layanan SIGAP</h3>
                                        <p class="text-xs text-slate-500">Status: Aktif & Siap Melayani</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Online</span>
                            </div>

                            <div class="space-y-3">
                                <div
                                    class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex items-start space-x-3">
                                    <div class="text-indigo-600 mt-0.5"><i class="fa-solid fa-file-lines text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-semibold text-slate-900">Buat Laporan Baru</h4>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Sampaikan keluhan fasilitas umum
                                            atau usulan pembangunan.</p>
                                    </div>
                                </div>
                                <div
                                    class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 flex items-start space-x-3">
                                    <div class="text-blue-600 mt-0.5"><i class="fa-solid fa-chart-line text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-semibold text-slate-900">Pantau Real-Time</h4>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Cek progres tindak lanjut dari
                                            instansi terkait secara langsung.</p>
                                    </div>
                                </div>
                            </div>

                            <a href="/masyarakat/login"
                                class="w-full py-3 px-4 rounded-xl bg-slate-900 hover:bg-indigo-600 text-white text-sm font-semibold flex items-center justify-center space-x-2 transition-colors duration-200 shadow-md">
                                <span>Mulai Buat Pengaduan</span>
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </a>
                        </div>
                        <!-- Decorative glow element behind card -->
                        <div
                            class="absolute -bottom-6 -right-6 w-72 h-72 bg-indigo-400/20 rounded-full blur-2xl -z-10 pointer-events-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FITUR UNGGULAN (FEATURES) -->
    <section id="fitur" class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                <h2 class="text-xs uppercase font-bold tracking-widest text-indigo-600">Keunggulan Platform</h2>
                <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Dirancang untuk Kemudahan
                    & Keamanan Publik</p>
                <p class="text-base text-slate-600">SIGAP menggabungkan teknologi modern dengan kemudahan akses agar
                    setiap laporan Anda tertangani secara profesional.</p>
            </div>

            <!-- Grid 3 Kolom -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div
                    class="bg-slate-50/50 hover:bg-white rounded-3xl p-8 border border-slate-200/80 hover:border-indigo-200 shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Akses Berbasis Multi-Panel</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Arsitektur terpisah untuk Masyarakat, Admin Utama, dan Instansi terkait untuk memastikan
                        pemisahan tugas dan kecepatan koordinasi penanganan.
                    </p>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-slate-50/50 hover:bg-white rounded-3xl p-8 border border-slate-200/80 hover:border-indigo-200 shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <i class="fa-solid fa-fingerprint"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Keamanan Autentikasi Ganda</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Validasi akun yang aman berbasis NIK atau Email terdaftar untuk melindungi privasi pelapor serta
                        menjaga keabsahan setiap laporan yang masuk.
                    </p>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-slate-50/50 hover:bg-white rounded-3xl p-8 border border-slate-200/80 hover:border-indigo-200 shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div
                        class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <i class="fa-solid fa-timeline"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Pelacakan Status Real-Time</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Pantau perjalanan laporan Anda mulai dari tahap verifikasi, disposisi ke instansi, proses
                        pengerjaan, hingga status selesai secara transparan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. ALUR PELAPORAN (WORKFLOW) -->
    <section id="alur" class="py-20 lg:py-28 bg-slate-50 border-t border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
                <h2 class="text-xs uppercase font-bold tracking-widest text-indigo-600">Langkah Mudah</h2>
                <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Bagaimana SIGAP Bekerja?
                </p>
                <p class="text-base text-slate-600">Hanya butuh 4 langkah sederhana untuk menyampaikan aspirasi atau
                    pengaduan Anda kepada pihak berwenang.</p>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
                <!-- Step 1 -->
                <div
                    class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm relative flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span
                                class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold flex items-center justify-center text-base shadow-md shadow-indigo-500/20">01</span>
                            <i class="fa-solid fa-user-plus text-2xl text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Daftar / Masuk</h3>
                        <p class="text-sm text-slate-600">Masuk ke akun Anda atau daftar menggunakan NIK dan data diri
                            yang valid melalui halaman login masyarakat.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <a href="/masyarakat/login"
                            class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center">
                            <span>Akses Halaman Login</span>
                            <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Step 2 -->
                <div
                    class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm relative flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span
                                class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold flex items-center justify-center text-base shadow-md shadow-indigo-500/20">02</span>
                            <i class="fa-solid fa-pen-to-square text-2xl text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Kirim Aspirasi</h3>
                        <p class="text-sm text-slate-600">Tuliskan laporan atau usulan secara detail, lampirkan foto
                            bukti pendukung, serta pilih kategori lokasi kejadian.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <span class="text-xs font-medium text-slate-400">Formulir Interaktif</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div
                    class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm relative flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span
                                class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold flex items-center justify-center text-base shadow-md shadow-indigo-500/20">03</span>
                            <i class="fa-solid fa-gear text-2xl text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Verifikasi & Tindak Lanjut</h3>
                        <p class="text-sm text-slate-600">Admin memverifikasi keabsahan laporan dan meneruskannya ke
                            instansi atau dinas teknis terkait.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <span class="text-xs font-medium text-slate-400">Disposisi Instansi</span>
                    </div>
                </div>

                <!-- Step 4 -->
                <div
                    class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm relative flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <span
                                class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold flex items-center justify-center text-base shadow-md shadow-indigo-500/20">04</span>
                            <i class="fa-solid fa-circle-check text-2xl text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Selesai & Transparan</h3>
                        <p class="text-sm text-slate-600">Laporan diselesaikan, Anda menerima pemberitahuan, dan status
                            publik dapat dilihat secara terbuka.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <span class="text-xs font-medium text-slate-400">Laporan Tuntas</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. FAQ SECTION -->
    <section id="faq" class="py-20 lg:py-28 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-4 mb-16">
                <h2 class="text-xs uppercase font-bold tracking-widest text-indigo-600">Pertanyaan Umum</h2>
                <p class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">FAQ Seputar SIGAP</p>
                <p class="text-base text-slate-600">Temukan jawaban cepat mengenai penggunaan platform pengaduan ini.
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button
                        class="faq-toggle w-full px-6 py-4 text-left font-semibold text-slate-900 flex justify-between items-center bg-slate-50 hover:bg-slate-100/80 focus:outline-none">
                        <span>Siapa saja yang dapat menggunakan aplikasi SIGAP?</span>
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200"></i>
                    </button>
                    <div
                        class="faq-content hidden px-6 py-4 text-sm text-slate-600 bg-white border-t border-slate-100">
                        Aplikasi ini dapat digunakan oleh seluruh warga masyarakat yang ingin menyampaikan pengaduan
                        fasilitas umum, infrastruktur, maupun aspirasi pembangunan daerah. Selain itu, terdapat panel
                        khusus untuk Admin dan Instansi terkait dalam mengelola pengaduan.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button
                        class="faq-toggle w-full px-6 py-4 text-left font-semibold text-slate-900 flex justify-between items-center bg-slate-50 hover:bg-slate-100/80 focus:outline-none">
                        <span>Bagaimana cara mulai mengirimkan laporan?</span>
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200"></i>
                    </button>
                    <div
                        class="faq-content hidden px-6 py-4 text-sm text-slate-600 bg-white border-t border-slate-100">
                        Anda cukup mengakses halaman login melalui tombol "Masuk / Login" di atas, membuat akun atau
                        masuk dengan kredensial Anda, lalu isi formulir laporan pengaduan pada dashboard masyarakat.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden transition-all duration-200">
                    <button
                        class="faq-toggle w-full px-6 py-4 text-left font-semibold text-slate-900 flex justify-between items-center bg-slate-50 hover:bg-slate-100/80 focus:outline-none">
                        <span>Apakah data dan identitas saya aman?</span>
                        <i class="fa-solid fa-chevron-down text-sm transition-transform duration-200"></i>
                    </button>
                    <div
                        class="faq-content hidden px-6 py-4 text-sm text-slate-600 bg-white border-t border-slate-100">
                        Ya, sistem kami menjamin kerahasiaan pelapor sesuai dengan regulasi perlindungan data privasi
                        yang berlaku, serta menggunakan validasi NIK yang aman.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. CALL TO ACTION (CTA) SECTION & FOOTER -->
    <footer class="bg-slate-900 text-slate-400 pt-20 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- CTA Banner Inside Footer Area -->
            <div
                class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-3xl p-8 sm:p-12 text-center text-white mb-16 shadow-2xl relative overflow-hidden">
                <div
                    class="absolute -right-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none">
                </div>
                <div class="max-w-2xl mx-auto space-y-6 relative z-10">
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Siap Berpartisipasi untuk
                        Pembangunan yang Lebih Baik?</h2>
                    <p class="text-indigo-100 text-base sm:text-lg">Sampaikan aspirasi atau pengaduan Anda sekarang
                        juga melalui portal resmi SIGAP.</p>
                    <div class="pt-2">
                        <a href="/masyarakat/login"
                            class="inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-bold text-indigo-900 bg-white hover:bg-indigo-50 shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-right-to-bracket mr-2"></i> Masuk / Login ke SIGAP
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Navigation & Branding -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-slate-800">
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold">
                            <i class="fa-solid fa-bullhorn text-sm"></i>
                        </div>
                        <span class="text-lg font-bold text-white tracking-tight">SIG<span
                                class="text-indigo-400">AP</span></span>
                    </div>
                    <p class="text-sm text-slate-400 max-w-sm leading-relaxed">
                        Sistem Informasi Aspirasi dan Pengaduan Masyarakat terintegrasi, transparan, dan cepat tanggap
                        berbasis teknologi modern.
                    </p>
                </div>

                <div>
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#beranda" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-white transition-colors">Fitur Unggulan</a></li>
                        <li><a href="#alur" class="hover:text-white transition-colors">Alur Pelaporan</a></li>
                        <li><a href="#faq" class="hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Akses Sistem</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/masyarakat/login"
                                class="hover:text-indigo-400 transition-colors flex items-center"><i
                                    class="fa-solid fa-angle-right mr-2 text-xs"></i> Login Masyarakat</a></li>
                        <li><span class="text-slate-600 cursor-not-allowed">Panel Admin (Internal)</span></li>
                        <li><span class="text-slate-600 cursor-not-allowed">Portal Instansi</span></li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; 2026 SIGAP (Sistem Informasi Aspirasi dan Pengaduan). Hak Cipta Dilindungi.</p>
                <div class="flex space-x-6 mt-4 sm:mt-0">
                    <span class="hover:text-slate-400 cursor-pointer">Kebijakan Privasi</span>
                    <span class="hover:text-slate-400 cursor-pointer">Syarat & Ketentuan</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu and FAQ Toggles -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // FAQ Accordion Toggle
        const faqToggles = document.querySelectorAll('.faq-toggle');
        faqToggles.forEach(btn => {
            btn.addEventListener('click', () => {
                const content = btn.nextElementSibling;
                const icon = btn.querySelector('i');

                // Toggle current
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });

        // Intercept login clicks to show a friendly custom toast before navigating
        const loginLinks = document.querySelectorAll('a[href="/masyarakat/login"]');
        const toast = document.getElementById('toast');
        const toastTitle = document.getElementById('toast-title');

        loginLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // If it's the anchor click, let's show our custom notification briefly
                e.preventDefault();
                const targetUrl = this.getAttribute('href');

                toastTitle.textContent = "Mengarahkan ke Login";
                toast.classList.remove('hidden');
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 10);

                setTimeout(() => {
                    window.location.href = targetUrl;
                }, 800);
            });
        });
    </script>
</body>

</html>
