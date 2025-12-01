<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Taskify' }}</title>

    @vite('resources/js/app.js')
</head>

<body class="font-sans antialiased bg-slate-900">
    {{-- Lapis gradient utama --}}
    <div class="min-h-screen flex flex-col bg-gradient-to-br from-sky-500 via-indigo-600 to-purple-700">

        {{-- HEADER khusus halaman tamu / auth --}}
        <header class="px-4 sm:px-8 py-4">
            <div class="max-w-6xl mx-auto flex items-center justify-between">
                {{-- Logo / brand --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div
                        class="h-9 w-9 rounded-2xl bg-gradient-to-br from-sky-300 via-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-lg">T</span>
                    </div>
                    <span class="text-sm sm:text-base font-semibold tracking-tight text-white">
                        Taskify
                    </span>
                </a>

                {{-- Tombol kanan: Masuk / Daftar sesuai halaman --}}
                <nav class="flex items-center gap-3 text-sm">
                    @if (Route::has('login') && Route::has('register'))
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-1.5 rounded-full bg-slate-900/80 text-white font-medium
                                               hover:bg-slate-900 transition">
                                    Logout
                                </button>
                            </form>
                        @else
                            @if (request()->routeIs('login'))
                                {{-- Sedang di LOGIN: hanya tombol Daftar --}}
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-4 py-1.5 rounded-full bg-white text-sky-700 font-medium
                                          shadow-sm hover:bg-slate-100 transition">
                                    Daftar
                                </a>
                            @elseif (request()->routeIs('register'))
                                {{-- Sedang di REGISTER: hanya tombol Masuk --}}
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center px-4 py-1.5 rounded-full bg-white text-sky-700 font-medium
                                          shadow-sm hover:bg-slate-100 transition">
                                    Masuk
                                </a>
                            @else
                                {{-- Guest page lain (kalau ada): dua tombol --}}
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-full border border-white/70 text-white font-medium
                                          hover:bg-white/10 transition">
                                    Masuk
                                </a>
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-4 py-1.5 rounded-full bg-white text-sky-700 font-medium
                                          shadow-sm hover:bg-slate-100 transition">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        {{-- Area konten: benar-benar center --}}
        <main class="flex-1 flex items-center justify-center px-4 py-8">
            <div class="w-full max-w-6xl">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
