<?php

use function Livewire\Volt\{state, rules};
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

state([
    'email' => '',
    'password' => '',
    'remember' => false,
]);

rules([
    'email' => 'required|email',
    'password' => 'required|string',
]);

$login = function () {
    $this->validate();

    if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    session()->regenerate();

    return redirect()->intended(route('dashboard', absolute: false));
};

?>

<x-guest-layout>
    <section class="w-full max-w-4xl grid gap-10 md:grid-cols-2 items-center">
        {{-- Side kiri: tagline / branding --}}
        <div
            class="hidden md:block rounded-3xl bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-600 p-[1px] shadow-xl">
            <div
                class="h-full w-full rounded-[1.4rem] bg-gradient-to-br from-sky-900/40 via-indigo-900/40 to-purple-900/40 p-6 flex flex-col justify-between">
                <div class="space-y-4 text-sky-50">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/20 backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        <span class="text-xs font-medium uppercase tracking-[0.2em]">
                            Taskify • Team Task Manager
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold leading-tight">
                        Kelola proyek & tugas timmu
                        <span class="text-amber-300">tanpa chaos</span>.
                    </h1>

                    <p class="text-sm text-sky-100/90">
                        Taskify membantu timmu memantau progres, deadline, dan prioritas dalam satu dashboard.
                        Cocok untuk kelompok belajar, UKM, sampai tim startup.
                    </p>
                </div>

                <ul class="mt-6 space-y-2 text-xs text-sky-100/90">
                    <li class="flex items-center gap-2">
                        <span
                            class="h-5 w-5 rounded-full bg-emerald-400/20 flex items-center justify-center text-[10px]">✓</span>
                        Progress bar proyek otomatis dari status tugas.
                    </li>
                    <li class="flex items-center gap-2">
                        <span
                            class="h-5 w-5 rounded-full bg-emerald-400/20 flex items-center justify-center text-[10px]">✓</span>
                        Highlight tugas yang mendekati atau lewat deadline.
                    </li>
                    <li class="flex items-center gap-2">
                        <span
                            class="h-5 w-5 rounded-full bg-emerald-400/20 flex items-center justify-center text-[10px]">✓</span>
                        Export tugas ke PDF sebagai laporan projek akhir.
                    </li>
                </ul>
            </div>
        </div>

        {{-- Side kanan: card login --}}
        <div class="w-full">
            <div class="bg-white/95 backdrop-blur rounded-3xl shadow-xl border border-slate-100 p-6 sm:p-8 space-y-6">
                <div class="flex items-center gap-3 mb-2">
                    <div
                        class="h-10 w-10 rounded-2xl bg-gradient-to-br from-sky-500 via-indigo-500 to-purple-600 flex items-center justify-center shadow-md">
                        <span class="text-white font-bold text-lg">T</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Selamat datang kembali</p>
                        <p class="text-sm font-semibold text-slate-800">Masuk ke Taskify</p>
                    </div>
                </div>

                @if (session('status'))
                    <div class="p-3 text-xs rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100">
                        {{ session('status') }}
                    </div>
                @endif

                <form wire:submit="login" class="space-y-4 md:space-y-5">
                    <div>
                        <label for="email" class="block mb-1 text-sm font-medium text-slate-700">
                            Email
                        </label>
                        <input type="email" id="email" wire:model="email" required autofocus
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
                        <input type="password" id="password" wire:model="password" required
                            class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-sky-500 focus:border-sky-500 block w-full px-3 py-2.5"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center gap-2 text-slate-600">
                            <input type="checkbox" wire:model="remember"
                                class="w-4 h-4 border border-slate-300 rounded bg-slate-50 text-sky-600 focus:ring-sky-500">
                            <span>Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="font-medium text-sky-600 hover:text-sky-700 hover:underline">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full inline-flex justify-center items-center gap-2 text-sm font-semibold text-white rounded-xl py-2.5
                               bg-gradient-to-r from-sky-500 via-indigo-500 to-purple-600
                               hover:from-sky-600 hover:via-indigo-600 hover:to-purple-700
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-400 focus:ring-offset-slate-50">
                        Masuk
                    </button>

                    @if (Route::has('register'))
                        <p class="text-xs text-center text-slate-500">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                                class="font-semibold text-sky-600 hover:text-sky-700 hover:underline">
                                Daftar sekarang
                            </a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>
