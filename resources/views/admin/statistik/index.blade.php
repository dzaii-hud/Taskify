<x-admin-layout title="Statistik Tugas User">

    <h1 class="text-2xl font-bold text-gray-200 mb-1">Statistik Semua User</h1>
    <p class="text-sm text-gray-400 mb-6">
        Ringkasan progres tugas seluruh user di Taskify.
    </p>

    @foreach ($stats as $item)
        <div class="bg-[#111] rounded-2xl shadow p-6 mb-10">

            <h2 class="text-lg font-semibold text-purple-300 mb-6">
                {{ $item['name'] }} — Statistik Tugas
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                {{-- PIE CHART --}}
                <div class="flex items-center justify-center">
                    <div class="w-40 h-40 md:w-52 md:h-52 relative">
                        <canvas id="chart-{{ $item['id'] }}" data-completed="{{ $item['completed'] }}"
                            data-ongoing="{{ $item['ongoing'] }}" style="width:100%;height:100%;display:block;">
                        </canvas>
                    </div>
                </div>

                {{-- DATA BOX --}}
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-6">

                    {{-- Total --}}
                    <div class="bg-[#151515] rounded-xl p-5 shadow-sm">
                        <p class="text-gray-400 text-sm">Total Tugas</p>
                        <p class="text-3xl font-bold mt-1 text-white">
                            {{ $item['total'] }}
                        </p>
                    </div>

                    {{-- Selesai --}}
                    <div class="bg-[#151515] rounded-xl p-5 shadow-sm">
                        <p class="text-gray-400 text-sm">Tugas Selesai</p>
                        <p class="text-3xl font-bold mt-1 text-green-500">
                            {{ $item['completed'] }}
                        </p>
                    </div>

                    {{-- On Going --}}
                    <div class="bg-[#151515] rounded-xl p-5 shadow-sm">
                        <p class="text-gray-400 text-sm">Sedang Dikerjakan</p>
                        <p class="text-3xl font-bold mt-1 text-yellow-500">
                            {{ $item['ongoing'] }}
                        </p>
                    </div>

                </div>
            </div>

        </div>
    @endforeach

    {{-- CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("canvas[id^='chart-']").forEach(canvas => {

                const completed = parseInt(canvas.dataset.completed);
                const ongoing = parseInt(canvas.dataset.ongoing);

                const ctx = canvas.getContext("2d");

                new Chart(ctx, {
                    type: "doughnut",
                    data: {
                        labels: ["Selesai", "Sedang Dikerjakan"],
                        datasets: [{
                            data: [completed, ongoing],
                            backgroundColor: [
                                "#4ADE80", // selesai
                                "#FACC15", // ongoing
                            ],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        cutout: "60%",
                        plugins: {
                            legend: {
                                position: "bottom",
                                labels: {
                                    color: "#d1d5db",
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>





</x-admin-layout>
