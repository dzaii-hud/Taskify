@extends('layouts.guest')

@section('content')
    <section class="w-full max-w-4xl grid gap-10 md:grid-cols-2 items-center">
        {{-- Side kiri: benefit buat user baru --}}
        <div
            class="hidden md:block rounded-3xl bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-600 p-[1px] shadow-xl">
            <div
                class="h-full w-full rounded-[1.4rem] bg-gradient-to-br from-sky-900/40 via-indigo-900/40 to-purple-900/40 p-6 flex flex-col justify-between">
                <div class="space-y-4 text-sky-50">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/20 backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        <span class="text-xs font-medium uppercase tracking-[0.2em]">
                            Mulai dengan Taskify
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold leading-tight">
                        Buat akun dan mulai
                        <span class="text-amber-300">merapikan tugas timmu</span>.
                    </h1>

                    <p class="text-sm text-sky-100/90">
                        Hanya butuh beberapa detik untuk membuat akun. Setelah itu kamu bisa membuat proyek,
                        menambahkan anggota tim, dan mengatur tugas sesuai deadline.
                    </p>
                </div>

                <ul class="mt-6 space-y-2 text-xs text-sky-100/90">
                    <li class="flex items-center gap-2">
                        <span
                            class="h-5 w-5 rounded-full bg-emerald-400/20 flex items-center justify-center text-[10px]">✓</span>
                        Pisahkan tugas berdasarkan proyek dan status.
                    </li>
                    <li class="flex items-center gap-2">
                        <span
                            class="h-5 w-5 rounded-full bg-emerald-400/20 flex items-center justify-center text-[10px]">✓</span>
                        Pantau persentase progres dengan progress bar.
                    </li>
                    <li class="flex items-center gap-2">
                        <span
                            class="h-5 w-5 rounded-full bg-emerald-400/20 flex items-center justify-center text-[10px]">✓</span>
                        Dukung projek akhir dengan laporan PDF yang rapi.
                    </li>
                </ul>
            </div>
        </div>

        {{-- Side kanan: form register --}}
        <div class="w-full">
            <div class="bg-white/95 backdrop-blur rounded-3xl shadow-xl border border-slate-100 p-6 sm:p-8 space-y-6">
                <div class="flex items-center gap-3 mb-2">
                    <div
                        class="h-10 w-10 rounded-2xl bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-lg">T</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Buat akun baru</p>
                        <p class="text-sm font-semibold text-slate-800">Daftar Akun Taskify</p>
                    </div>
                </div>

                <form class="space-y-4 md:space-y-5" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <label for="name" class="block mb-1 text-sm font-medium text-slate-700">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                            class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full px-3 py-2.5"
                            placeholder="Nama kamu">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block mb-1 text-sm font-medium text-slate-700">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full px-3 py-2.5"
                            placeholder="nama@contoh.com">
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block mb-1 text-sm font-medium text-slate-700">
                            Password
                        </label>
                        <input type="password" name="password" id="password" required
                            class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full px-3 py-2.5"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-1 text-sm font-medium text-slate-700">
                            Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full px-3 py-2.5"
                            placeholder="••••••••">
                    </div>

                    <button type="submit"
                        class="w-full inline-flex justify-center items-center gap-2 text-sm font-semibold text-white rounded-xl py-2.5
                               bg-gradient-to-r from-sky-500 via-indigo-500 to-purple-600
                               hover:from-sky-600 hover:via-indigo-600 hover:to-purple-700
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-400 focus:ring-offset-slate-50">
                        Daftar
                    </button>

                    @if (Route::has('login'))
                        <p class="text-xs text-center text-slate-500">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="font-semibold text-sky-600 hover:text-sky-700 hover:underline">
                                Masuk di sini
                            </a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </section>
@endsection
