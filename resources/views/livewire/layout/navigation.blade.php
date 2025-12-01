@php
    // Halaman-halaman auth di mana kita TIDAK mau menampilkan nav Livewire,
    // karena sudah punya header sendiri di layouts.guest
    $isAuthPage =
        request()->routeIs('login') ||
        request()->routeIs('register') ||
        request()->routeIs('password.*') ||
        request()->routeIs('verification.*');
@endphp

@if (!$isAuthPage)
    <nav class="bg-white/80 backdrop-blur border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                {{-- Brand Taskify (klik ke landing atau dashboard) --}}
                <div class="flex items-center gap-2">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logozafataskify.png') }}" alt="Taskify" class="h-20 md:h-20 w-auto">
                        <span class="text-sm sm:text-base font-semibold tracking-tight text-slate-800">
                            
                        </span>
                    </a>


                    {{-- Right side --}}
                    <div class="flex items-center gap-3 text-sm">
                        @auth
                            {{-- USER SUDAH LOGIN: tampil nama + tombol logout --}}
                            <span class="hidden sm:inline text-slate-700">
                                Halo, <span class="font-semibold">{{ auth()->user()->name }}</span>
                            </span>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-1.5 rounded-full bg-slate-900 text-white font-medium
                                       hover:bg-slate-800 transition">
                                    Logout
                                </button>
                            </form>
                        @else
                            {{-- USER BELUM LOGIN di halaman non-auth (misal landing) --}}
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-full border border-sky-600 text-sky-700 font-medium
                                      hover:bg-sky-50 transition">
                                    Masuk
                                </a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-4 py-1.5 rounded-full bg-sky-600 text-white font-medium
                                      hover:bg-sky-700 transition">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
    </nav>
@endif
