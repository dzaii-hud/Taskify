<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskify - Aplikasi Pengelolaan Tugas Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        secondary: '#0f172a',
                        accent: '#f59e0b',
                        light: '#f8fafc',
                        dark: '#1e293b'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .smooth-scroll {
            scroll-behavior: smooth;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .demo-screen {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>

<body class="smooth-scroll bg-white text-gray-900">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logozafataskify.png') }}" alt="Taskify" class="h-20 md:h-20 w-auto">
                        <span class="text-2xl font-bold text-secondary">
                            Taskify
                        </span>
                    </div>
                </div>


                <div class="hidden md:flex items-center gap-8">
                    <a href="#about" class="text-gray-700 hover:text-primary transition">Tentang</a>
                    <a href="#features" class="text-gray-700 hover:text-primary transition">Fitur</a>
                    <a href="#story" class="text-gray-700 hover:text-primary transition">Cerita</a>
                    <a href="#demo" class="text-gray-700 hover:text-primary transition">Demo</a>
                    <a href="#pricing" class="text-gray-700 hover:text-primary transition">Harga</a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}"
                        class="hidden sm:inline-block text-gray-700 hover:text-primary transition">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}"
                        class="bg-secondary text-white px-6 py-2 rounded-full hover:bg-opacity-90 transition font-medium">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-16 md:pt-32 md:pb-24 hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-block mb-4 px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium">
                    ✨ Tingkatkan produktivitas hingga 300%
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight">
                    Kelola Tugas dengan <span class="text-yellow-300">Lebih Cerdas</span>
                </h1>
                <p class="text-lg sm:text-xl md:text-2xl mb-8 text-white/90 leading-relaxed max-w-3xl mx-auto">
                    Platform pengelolaan tugas modern yang membantu tim Anda berkolaborasi lebih efektif dan
                    menyelesaikan pekerjaan lebih cepat
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#pricing"
                        class="w-full sm:w-auto bg-white text-primary px-8 py-4 rounded-full font-semibold text-lg hover:bg-opacity-90 transition shadow-lg">
                        Mulai Gratis Sekarang
                    </a>
                    <a href="#demo"
                        class="w-full sm:w-auto bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white/10 transition">
                        Lihat Demo
                    </a>
                </div>
                <p class="mt-6 text-sm text-white/80">Gratis 14 hari • Tidak perlu kartu kredit • Batalkan kapan saja
                </p>
            </div>

            <!-- Hero Image/Stats -->
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                    <div class="text-3xl md:text-4xl font-bold mb-2">50K+</div>
                    <div class="text-sm text-white/80">Pengguna Aktif</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                    <div class="text-3xl md:text-4xl font-bold mb-2">98%</div>
                    <div class="text-sm text-white/80">Kepuasan</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                    <div class="text-3xl md:text-4xl font-bold mb-2">2M+</div>
                    <div class="text-sm text-white/80">Tugas Selesai</div>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                    <div class="text-3xl md:text-4xl font-bold mb-2">24/7</div>
                    <div class="text-sm text-white/80">Dukungan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 md:py-24 bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div
                        class="inline-block mb-4 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold">
                        Tentang Kami
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 text-secondary leading-tight">
                        Solusi Produktivitas untuk Tim Modern
                    </h2>
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Taskify adalah platform pengelolaan tugas yang dirancang khusus untuk tim yang ingin bekerja
                        lebih efisien. Kami percaya bahwa produktivitas bukan tentang bekerja lebih keras, tetapi
                        bekerja lebih cerdas.
                    </p>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Dengan antarmuka yang intuitif dan fitur kolaborasi yang powerful, Taskify membantu ribuan tim
                        di seluruh dunia mencapai tujuan mereka dengan lebih cepat dan terorganisir.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-semibold text-secondary">Mudah Digunakan</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="font-semibold text-secondary">Super Cepat</span>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-4 bg-green-50 rounded-xl border-l-4 border-green-500">
                                <div
                                    class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold">
                                    ✓</div>
                                <div class="flex-1">
                                    <div class="font-semibold text-secondary">Desain Landing Page</div>
                                    <div class="text-sm text-gray-500">Selesai 2 jam yang lalu</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl border-l-4 border-blue-500">
                                <div
                                    class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                    →</div>
                                <div class="flex-1">
                                    <div class="font-semibold text-secondary">Review Kode Backend</div>
                                    <div class="text-sm text-gray-500">Sedang berlangsung</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border-l-4 border-gray-300">
                                <div
                                    class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold">
                                    ○</div>
                                <div class="flex-1">
                                    <div class="font-semibold text-secondary">Testing Aplikasi</div>
                                    <div class="text-sm text-gray-500">Dijadwalkan besok</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block mb-4 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold">
                    Fitur Unggulan
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 text-secondary leading-tight">
                    Semua yang Anda Butuhkan dalam Satu Platform
                </h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Fitur-fitur powerful yang dirancang untuk meningkatkan produktivitas tim Anda
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-secondary">Manajemen Tugas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Buat, atur, dan lacak tugas dengan mudah. Tetapkan prioritas, deadline, dan tag untuk organisasi
                        yang lebih baik.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-secondary">Kolaborasi Tim</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Bekerja bersama secara real-time. Bagikan tugas, berikan komentar, dan tetap sinkron dengan tim
                        Anda.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-secondary">Laporan & Analitik</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dapatkan insight mendalam tentang produktivitas tim dengan dashboard analitik yang komprehensif.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-secondary">Time Tracking</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lacak waktu yang dihabiskan untuk setiap tugas dan proyek untuk manajemen waktu yang lebih baik.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-secondary">Notifikasi Cerdas</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Tetap update dengan notifikasi yang dapat dikustomisasi untuk deadline, mention, dan update
                        penting.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white border border-gray-200 rounded-2xl p-8 card-hover">
                    <div class="w-14 h-14 bg-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-secondary">Mobile App</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Akses tugas Anda dari mana saja dengan aplikasi mobile yang tersedia untuk iOS dan Android.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Story Section -->
    <section id="story" class="py-16 md:py-24 bg-secondary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <div
                        class="inline-block mb-4 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-semibold">
                        Cerita Kami
                    </div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 leading-tight">
                        Dari Masalah Menjadi Solusi
                    </h2>
                    <div class="space-y-6 text-lg text-white/90 leading-relaxed">
                        <p>
                            Taskify lahir dari pengalaman pribadi kami dalam mengelola proyek-proyek kompleks. Kami
                            merasakan sendiri betapa frustrasinya menggunakan tools yang rumit dan tidak intuitif.
                        </p>
                        <p>
                            Pada tahun 2025, kami memutuskan untuk membuat solusi yang berbeda - sebuah platform yang
                            powerful namun mudah digunakan, yang fokus pada apa yang benar-benar penting: menyelesaikan
                            pekerjaan.
                        </p>
                        <p>
                            Hari ini, Taskify digunakan oleh lebih dari 50,000 profesional di seluruh dunia, dari
                            startup hingga perusahaan Fortune 500. Dan kami baru saja memulai.
                        </p>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-6">
                        <div>
                            <div class="text-4xl font-bold text-accent mb-2">2025</div>
                            <div class="text-white/80">Tahun Didirikan</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold text-accent mb-2">150+</div>
                            <div class="text-white/80">Negara</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-accent rounded-full flex items-center justify-center flex-shrink-0 text-2xl">
                                    🚀
                                </div>
                                <div>
                                    <div class="font-bold text-lg mb-2">Misi Kami</div>
                                    <p class="text-white/80 leading-relaxed">
                                        Memberdayakan setiap tim untuk mencapai potensi maksimal mereka melalui
                                        teknologi yang sederhana namun powerful.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-accent rounded-full flex items-center justify-center flex-shrink-0 text-2xl">
                                    👁️
                                </div>
                                <div>
                                    <div class="font-bold text-lg mb-2">Visi Kami</div>
                                    <p class="text-white/80 leading-relaxed">
                                        Menjadi platform pengelolaan tugas #1 di dunia yang dipercaya oleh jutaan tim
                                        untuk menyelesaikan pekerjaan terbaik mereka.
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-accent rounded-full flex items-center justify-center flex-shrink-0 text-2xl">
                                    💎
                                </div>
                                <div>
                                    <div class="font-bold text-lg mb-2">Nilai Kami</div>
                                    <p class="text-white/80 leading-relaxed">
                                        Kesederhanaan, inovasi, dan fokus pada pengguna adalah inti dari semua yang kami
                                        lakukan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-16 md:py-24 bg-light">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block mb-4 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold">
                    Demo Interaktif
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 text-secondary leading-tight">
                    Lihat Taskify dalam Aksi
                </h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Jelajahi antarmuka intuitif kami dan lihat betapa mudahnya mengelola tugas dengan Taskify
                </p>
            </div>

            <!-- Demo Screenshot/Mockup -->
            <div class="max-w-6xl mx-auto">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden demo-screen">
                    <!-- Browser Bar -->
                    <div class="bg-gray-100 px-4 py-3 flex items-center gap-2 border-b">
                        <div class="flex gap-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        </div>
                        <div class="flex-1 mx-4">
                            <div class="bg-white rounded px-4 py-1 text-sm text-gray-500">app.taskify.com/dashboard
                            </div>
                        </div>
                    </div>

                    <!-- Demo Content -->
                    <div class="p-8 bg-gradient-to-br from-gray-50 to-white">
                        <div class="grid md:grid-cols-3 gap-6">
                            <!-- Column 1: To Do -->
                            <div class="bg-white rounded-xl p-6 border-2 border-gray-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-bold text-secondary flex items-center gap-2">
                                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                        To Do
                                    </h3>
                                    <span class="text-sm text-gray-500">5</span>
                                </div>
                                <div class="space-y-3">
                                    <div
                                        class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition cursor-pointer">
                                        <div class="font-semibold text-sm mb-2">Desain UI Dashboard</div>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">Design</span>
                                            <span>📅 Besok</span>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition cursor-pointer">
                                        <div class="font-semibold text-sm mb-2">Review Kode API</div>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded">Dev</span>
                                            <span>📅 Minggu ini</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 2: In Progress -->
                            <div class="bg-white rounded-xl p-6 border-2 border-primary">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-bold text-secondary flex items-center gap-2">
                                        <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                                        In Progress
                                    </h3>
                                    <span class="text-sm text-gray-500">3</span>
                                </div>
                                <div class="space-y-3">
                                    <div
                                        class="bg-primary/5 rounded-lg p-4 border-2 border-primary hover:shadow-md transition cursor-pointer">
                                        <div class="font-semibold text-sm mb-2">Implementasi Auth</div>
                                        <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded">Backend</span>
                                            <span>📅 Hari ini</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-primary h-2 rounded-full" style="width: 65%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">65% selesai</div>
                                    </div>
                                    <div
                                        class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition cursor-pointer">
                                        <div class="font-semibold text-sm mb-2">Testing Mobile App</div>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded">QA</span>
                                            <span>📅 Hari ini</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 3: Done -->
                            <div class="bg-white rounded-xl p-6 border-2 border-gray-200">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="font-bold text-secondary flex items-center gap-2">
                                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                        Done
                                    </h3>
                                    <span class="text-sm text-gray-500">8</span>
                                </div>
                                <div class="space-y-3">
                                    <div class="bg-green-50 rounded-lg p-4 border border-green-200 opacity-75">
                                        <div class="font-semibold text-sm mb-2 line-through">Setup Database</div>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded">Backend</span>
                                            <span>✅ Kemarin</span>
                                        </div>
                                    </div>
                                    <div class="bg-green-50 rounded-lg p-4 border border-green-200 opacity-75">
                                        <div class="font-semibold text-sm mb-2 line-through">Wireframe Landing</div>
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">Design</span>
                                            <span>✅ 2 hari lalu</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Demo Features -->
                <div class="grid sm:grid-cols-3 gap-6 mt-12">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-secondary mb-2">Drag & Drop</h4>
                        <p class="text-gray-600 text-sm">Pindahkan tugas dengan mudah antar kolom</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-secondary mb-2">Real-time Sync</h4>
                        <p class="text-gray-600 text-sm">Update langsung untuk semua anggota tim</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-secondary mb-2">Kustomisasi</h4>
                        <p class="text-gray-600 text-sm">Sesuaikan workflow dengan kebutuhan Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block mb-4 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold">
                    Harga Transparan
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 text-secondary leading-tight">
                    Pilih Paket yang Tepat untuk Tim Anda
                </h2>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Mulai gratis, upgrade kapan saja. Tidak ada biaya tersembunyi.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Free Plan -->
                <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-secondary mb-2">Gratis</h3>
                        <div class="text-4xl font-bold text-secondary mb-2">Rp 0</div>
                        <div class="text-gray-500">Selamanya</div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Hingga 10 tugas aktif</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">3 anggota tim</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Fitur dasar</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Mobile app</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="text-gray-400">Laporan & analitik</span>
                        </li>
                    </ul>
                    <button
                        class="w-full bg-gray-100 text-secondary py-3 rounded-full font-semibold hover:bg-gray-200 transition">
                        Mulai Gratis
                    </button>
                </div>

                <!-- Pro Plan (Featured) -->
                <div class="bg-primary text-white rounded-2xl p-8 relative shadow-2xl transform md:scale-105">
                    <div
                        class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-accent text-white px-4 py-1 rounded-full text-sm font-semibold">
                        Paling Populer
                    </div>
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold mb-2">Pro</h3>
                        <div class="text-4xl font-bold mb-2">Rp 99K</div>
                        <div class="text-white/80">per bulan</div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Tugas unlimited</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Hingga 25 anggota tim</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Semua fitur dasar</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Laporan & analitik</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Integrasi pihak ketiga</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-accent flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Priority support</span>
                        </li>
                    </ul>
                    <button
                        class="w-full bg-white text-primary py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                        Coba 14 Hari Gratis
                    </button>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 hover:shadow-xl transition">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-secondary mb-2">Enterprise</h3>
                        <div class="text-4xl font-bold text-secondary mb-2">Custom</div>
                        <div class="text-gray-500">Hubungi kami</div>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Semua fitur Pro</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Anggota unlimited</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Dedicated account manager</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">Custom integrations</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">SLA & security</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-600">On-premise option</span>
                        </li>
                    </ul>
                    <button
                        class="w-full bg-secondary text-white py-3 rounded-full font-semibold hover:bg-opacity-90 transition">
                        Hubungi Sales
                    </button>
                </div>
            </div>

            <!-- Pricing FAQ -->
            <div class="mt-16 text-center">
                <p class="text-gray-600 mb-4">Semua paket termasuk uji coba gratis 14 hari. Tidak perlu kartu kredit.
                </p>
                <a href="#" class="text-primary font-semibold hover:underline">Lihat perbandingan lengkap fitur
                    →</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 md:py-24 bg-secondary text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Siap Meningkatkan Produktivitas Tim Anda?
            </h2>
            <p class="text-xl text-white/90 mb-8 leading-relaxed">
                Bergabunglah dengan 50,000+ profesional yang sudah mempercayai Taskify untuk mengelola pekerjaan mereka
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#pricing"
                    class="w-full sm:w-auto bg-accent text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-opacity-90 transition shadow-lg">
                    Mulai Gratis Sekarang
                </a>
                <a href="#demo"
                    class="w-full sm:w-auto bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white/10 transition">
                    Jadwalkan Demo
                </a>
            </div>
            <p class="mt-6 text-sm text-white/70">✓ Gratis 14 hari ✓ Tidak perlu kartu kredit ✓ Setup dalam 2 menit</p>

            <!-- Trust Badges -->
            <div class="mt-12 pt-12 border-t border-white/20">
                <p class="text-white/60 text-sm mb-6">Dipercaya oleh tim dari perusahaan terkemuka</p>
                <div class="flex flex-wrap items-center justify-center gap-8 opacity-60">
                    <div class="text-2xl font-bold">Google</div>
                    <div class="text-2xl font-bold">Microsoft</div>
                    <div class="text-2xl font-bold">Amazon</div>
                    <div class="text-2xl font-bold">Spotify</div>
                    <div class="text-2xl font-bold">Netflix</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logozafataskify.png') }}" alt="Taskify"
                            class="h-20 md:h-20 w-auto">
                        <span class="text-xl font-bold">
                            Taskify
                        </span>
                    </div>

                    <p class="text-white/70 text-sm leading-relaxed">
                        Platform pengelolaan tugas modern untuk tim yang produktif.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Produk</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="#features" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Harga</a></li>
                        <li><a href="#demo" class="hover:text-white transition">Demo</a></li>
                        <li><a href="#" class="hover:text-white transition">Integrasi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="#about" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#story" class="hover:text-white transition">Cerita</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Dukungan</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="#" class="hover:text-white transition">Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition">Dokumentasi</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                        <li><a href="#" class="hover:text-white transition">Status</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-white/60">© 2025 Taskify. All rights reserved.</p>
                <div class="flex items-center gap-6 text-sm text-white/60">
                    <a href="#" class="hover:text-white transition">Privasi</a>
                    <a href="#" class="hover:text-white transition">Syarat</a>
                    <a href="#" class="hover:text-white transition">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Smooth Scroll Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
