@props(['title' => 'Admin Panel'])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- AOS --}}
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body class="bg-[#0d0d16] text-gray-200 font-inter">

    <div class="min-h-screen flex">

        {{-- ========================= --}}
        {{--         SIDEBAR           --}}
        {{-- ========================= --}}
        <aside class="w-64 bg-[#131325] border-r border-purple-700/20 shadow-xl flex flex-col justify-between">

            {{-- HEADER --}}
            <div>
                <div class="p-6 border-b border-purple-700/20 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-lg bg-purple-600 shadow-lg shadow-purple-500/40"></div>
                    <h1 class="text-lg font-bold tracking-wide text-purple-300">
                        ADMIN PANEL
                    </h1>
                </div>

                {{-- MENU --}}
                <nav class="mt-6 px-4 space-y-2 text-sm">

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 p-2 rounded-lg transition
                        {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600/30 text-purple-300' : 'hover:bg-purple-600/20' }}">
                        🛠️ <span>Dashboard Admin</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 p-2 rounded-lg transition
                        {{ request()->routeIs('admin.users.*') ? 'bg-purple-600/30 text-purple-300' : 'hover:bg-purple-600/20' }}">
                        👥 <span>Manajemen User</span>
                    </a>

                    <a href="{{ route('admin.projects.index') }}"
                        class="flex items-center gap-3 p-2 rounded-lg transition
                        {{ request()->routeIs('admin.projects.*') ? 'bg-purple-600/30 text-purple-300' : 'hover:bg-purple-600/20' }}">
                        📁 <span>Manajemen Proyek</span>
                    </a>

                    <a href="{{ route('admin.tasks.index') }}"
                        class="flex items-center gap-3 p-2 rounded-lg transition
                        {{ request()->routeIs('admin.tasks.*') ? 'bg-purple-600/30 text-purple-300' : 'hover:bg-purple-600/20' }}">
                        📝 <span>Semua Tugas</span>
                    </a>

                    {{-- ============================================= --}}
                    {{--          🔔 MENU NOTIFIKASI ADMIN             --}}
                    {{-- ============================================= --}}
                    @php
                        $adminUnread = \App\Models\Notification::where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->count();
                    @endphp

                    <a href="{{ route('admin.notifications.index') }}"
                        class="flex items-center justify-between gap-3 p-2 rounded-lg transition
                        {{ request()->routeIs('admin.notifications') ? 'bg-purple-600/30 text-purple-300' : 'hover:bg-purple-600/20' }}">

                        <span class="flex items-center gap-3">
                            🔔 <span>Notifikasi</span>
                        </span>

                        @if ($adminUnread > 0)
                            <span class="text-xs bg-red-600 px-2 py-0.5 rounded-full">
                                {{ $adminUnread }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.statistik.index') }}"
                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-purple-600/20
                        {{ request()->routeIs('admin.statistics.index') ? 'bg-purple-600/30 text-purple-300' : '' }}">
                        📊 <span>Statistik</span>
                    </a>


                    <a href="{{ route('admin.settings') }}"
                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-purple-600/20 transition">
                        ⚙️ <span>Pengaturan Sistem</span>
                    </a>

                </nav>
            </div>

            {{-- FOOTER --}}
            <div class="p-4 border-t border-purple-700/20">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-2
                        bg-purple-700 hover:bg-purple-800 rounded-lg transition shadow-md shadow-purple-600/20">
                        🚪 Logout
                    </button>
                </form>
            </div>

        </aside>

        {{-- ========================= --}}
        {{--         MAIN CONTENT       --}}
        {{-- ========================= --}}
        <main class="flex-1 p-8" data-aos="fade-up">

            @if ($title)
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-purple-300 tracking-wide">
                        {{ $title }}
                    </h1>
                </div>
            @endif

            <div class="mt-4">
                {{ $slot }}
            </div>

        </main>

    </div>

    @livewireScripts
    @stack('scripts')

    <script>
        AOS.init({
            duration: 900,
            once: true,
        });
    </script>

    @stack('modals')

</body>

</html>
