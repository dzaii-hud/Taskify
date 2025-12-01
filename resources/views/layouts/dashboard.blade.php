<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Taskify Dashboard' }}</title>

    {{-- 🎨 AOS (Animate On Scroll) --}}
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    {{-- 🎨 Tailwind & Livewire --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans bg-gray-50 text-gray-800">
    <div class="min-h-screen flex">

        {{-- 🌈 SIDEBAR --}}
        <aside class="w-64 bg-gradient-to-b from-indigo-600 to-sky-500 text-white flex flex-col justify-between">

            {{-- 🔹 Logo --}}
            <div>
                <div class="p-6 flex items-center gap-3 border-b border-indigo-400/40">
                    <img src="{{ asset('images/logozafataskify.png') }}" alt="Taskify" class="h-20 md:h-20 w-auto">
                    <h1 class="font-bold text-lg tracking-wide"></h1>
                </div>

                {{-- 🔔 NOTIFIKASI (badge + link) --}}
                @php
                    $notifCount = \App\Models\Notification::where('user_id', auth()->id())
                        ->where('is_read', false)
                        ->count();
                    $recentNotifs = \App\Models\Notification::where('user_id', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                <div class="px-4 py-3 border-b border-indigo-400/20">
                    <a href="{{ route('notifications.index') }}"
                        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-indigo-700 transition">
                        <span class="text-lg">🔔</span>
                        <span class="text-sm">Notifikasi</span>
                        @if ($notifCount > 0)
                            <span
                                class="ml-auto inline-flex items-center justify-center w-6 h-6 text-xs rounded-full bg-red-500 text-white">{{ $notifCount }}</span>
                        @endif
                    </a>
                </div>

                {{-- 🔹 MENU SIDEBAR --}}
                <nav class="mt-6 px-4 space-y-2 text-sm">

                    {{-- ========================================================= --}}
                    {{--                MENU UNTUK ADMIN                         --}}
                    {{-- ========================================================= --}}
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 p-2 rounded-lg transition
                            {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">
                            🛠️ <span>Dashboard Admin</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 p-2 rounded-lg transition
                            {{ request()->routeIs('admin.users.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">
                            👥 <span>Manajemen User</span>
                        </a>

                        <a href="{{ route('admin.projects.index') }}"
                            class="flex items-center gap-3 p-2 rounded-lg transition
                            {{ request()->routeIs('admin.projects.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">
                            📁 <span>Manajemen Proyek</span>
                        </a>

                        <a href="{{ route('admin.tasks.index') }}"
                            class="flex items-center gap-3 p-2 rounded-lg transition
                            {{ request()->routeIs('admin.tasks.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}">
                            📝 <span>Semua Tugas</span>
                        </a>

                        <a href="{{ route('admin.reports') }}"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-700 transition">
                            📈 <span>Laporan</span>
                        </a>

                        <a href="{{ route('admin.settings') }}"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-700 transition">
                            ⚙️ <span>Pengaturan Sistem</span>
                        </a>

                        {{-- ========================================================= --}}
                        {{--                MENU UNTUK USER                          --}}
                        {{-- ========================================================= --}}
                    @else
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-3 p-2 rounded-lg transition
                                {{ request()->routeIs('dashboard') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }}"
                            onclick="if(window.location.pathname === '{{ route('dashboard', [], false) }}'){ location.reload(); return false; }">
                            📊 <span>Dashboard</span>
                        </a>

                        <a href="{{ route('projects.index') }}"
                            class="flex items-center gap-3 p-2 rounded-lg text-sm
                                {{ request()->routeIs('projects.*') ? 'bg-indigo-700' : 'hover:bg-indigo-700' }} transition">
                            📁 <span>Proyek</span>
                        </a>

                        <a href="{{ route('tasks.all') }}"
                            class="flex items-center gap-3 p-2 rounded-lg transition
                                {{ request()->routeIs('tasks.all') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-700' }}">
                            📝 <span>Tugas</span>
                        </a>





                        {{-- 🔔 MENU NOTIFIKASI (yang ini dibikin aktif kalau halaman notif dibuka) --}}
                        <a href="{{ route('notifications.index') }}"
                            class="flex items-center gap-3 p-2 rounded-lg transition
                                {{ request()->routeIs('notifications.*') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-700' }}">
                            🔔 <span>Notifikasi</span>
                        </a>

                        <a href="{{ route('statistik.index') }}"
                            class="flex items-center gap-3 p-2 rounded-lg transition
                               {{ request()->routeIs('statistik.index') ? 'bg-indigo-700 text-white' : 'hover:bg-indigo-700' }}">
                            📈 <span>Statistik</span>
                        </a>

                        

                        <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-700 transition">
                            ⚙️ <span>Pengaturan</span>
                        </a>

                        <a href="#" class="flex items-center gap-3 p-2 rounded-lg hover:bg-indigo-700 transition">
                            💬 <span>Pusat Bantuan</span>
                        </a>
                    @endif
                </nav>
            </div>

            {{-- 🔹 LOGOUT --}}
            <div class="p-4 border-t border-indigo-400/40">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-2 bg-indigo-700 hover:bg-indigo-800 rounded-lg transition">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- 🌟 KONTEN UTAMA --}}
        <main class="flex-1 p-8 overflow-y-auto" data-aos="fade-up">
            {{ $slot }}
        </main>
    </div>

    {{-- 📜 Scripts --}}
    @livewireScripts
    @stack('scripts')

    <script>
        AOS.init({
            duration: 900,
            once: true,
        });
    </script>

    {{-- Global Modal --}}
    @stack('modals')

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>

</body>

</html>
