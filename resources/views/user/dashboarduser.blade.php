<x-dashboard-layout title="Dashboard User">

    {{-- 🔹 WELCOME CARD --}}
    <div data-aos="fade-up"
        class="bg-gradient-to-r from-sky-500 to-indigo-500 text-white rounded-2xl p-6 shadow-md mb-10">
        <h1 class="text-3xl font-bold">Halo, {{ auth()->user()->name }} 👋</h1>
        <p class="text-sm text-sky-100 mt-1">Selamat datang kembali di Taskify! Semoga harimu produktif 💪</p>
    </div>

    <div class="space-y-10">

        {{-- 🔹 PROGRESS PROYEK --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-4">Progress Proyek Kamu</h2>

            @if ($projects->isEmpty())
                <p class="text-gray-500">Kamu belum memiliki proyek.</p>
            @else
                <div class="space-y-4">
                    @foreach ($projects as $project)
                        <div class="border p-4 rounded-lg bg-gradient-to-br from-slate-50 to-gray-100">

                            {{-- Nama proyek & jumlah tugas --}}
                            <div class="flex justify-between mb-2">
                                <span class="font-medium text-gray-800">{{ $project->name }}</span>
                                <span class="text-sm text-gray-600">
                                    {{ $project->done_tasks }} / {{ $project->total_tasks }} tugas
                                </span>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="progress-fill h-3 rounded-full" data-progress="{{ $project->progress }}"
                                    style="
                                        width: 0%;
                                        background: linear-gradient(to right, #06b6d4, #3b82f6, #8b5cf6);
                                    ">
                                </div>
                            </div>

                            <div class="text-right text-sm font-semibold mt-1 text-indigo-600">
                                {{ $project->progress }}%
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- 🔹 PROGRESS BAR ANIMATION --}}
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const bars = document.querySelectorAll(".progress-fill");

                bars.forEach((bar, i) => {
                    const target = bar.dataset.progress;

                    setTimeout(() => {
                        bar.style.transition = "width 1.8s ease-in-out";
                        bar.style.width = target + "%";
                    }, 300 + i * 150);
                });
            });
        </script>
    @endpush

</x-dashboard-layout>
