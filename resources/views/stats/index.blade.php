<x-dashboard-layout title="Statistik Tugas">

    <h1 class="text-2xl font-bold text-gray-800 mb-1">Statistik Tugas</h1>
    <p class="text-sm text-gray-500 mb-6">
        Ringkasan progres tugas yang kamu kerjakan di Taskify.
    </p>

    {{-- CARD UTAMA --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="text-lg font-semibold text-gray-800 mb-6">
            Grafik Penyelesaian Tugas
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

            {{-- PIE CHART --}}
            <div class="flex items-center justify-center">
                <div class="w-40 h-40 md:w-52 md:h-52 relative">
                    {{-- canvas di-set 100% supaya mewarisi ukuran parent --}}
                    <canvas id="taskChart" style="width:100%;height:100%;display:block;"></canvas>
                </div>
            </div>

            {{-- DATA BOX --}}
            <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-6">

                {{-- Total --}}
                <div class="bg-gray-50 rounded-xl p-5 shadow-sm">
                    <p class="text-gray-500 text-sm">Total Tugas</p>
                    <p id="stat-total" class="text-3xl font-bold mt-1">{{ $total }}</p>
                </div>

                {{-- Selesai --}}
                <div class="bg-gray-50 rounded-xl p-5 shadow-sm">
                    <p class="text-gray-500 text-sm">Tugas Selesai</p>
                    <p id="stat-completed" class="text-3xl font-bold text-green-600 mt-1">{{ $completed }}</p>
                </div>

                {{-- On Going --}}
                <div class="bg-gray-50 rounded-xl p-5 shadow-sm">
                    <p class="text-gray-500 text-sm">Sedang Dikerjakan</p>
                    <p id="stat-ongoing" class="text-3xl font-bold text-yellow-600 mt-1">{{ $ongoing }}</p>
                </div>

            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // tunggu DOM siap dulu supaya ukuran parent sudah terpasang
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('taskChart');
            // ctx dari canvas (pastikan element ada)
            const ctx = canvas.getContext('2d');

            // ambil angka dari blade (safely cast ke number)
            let completed = Number({{ $completed }});
            let ongoing = Number({{ $ongoing }});
            let hasData = (completed + ongoing) > 0;

            // buat chart (maintainAspectRatio false agar mengikuti parent height)
            const chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: hasData ? ['Selesai', 'Sedang Dikerjakan'] : ['Belum Ada Data'],
                    datasets: [{
                        data: hasData ? [completed, ongoing] : [1], // fallback supaya donut muncul
                        backgroundColor: hasData ? ['#22c55e', '#facc15'] : ['#e5e7eb']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // resize kecil (kadang perlu setelah tailwind render)
            setTimeout(() => chart.resize(), 200);

            // fungsi refresh realtime
            async function refreshStats() {
                try {
                    const res = await fetch("{{ route('statistik.data') }}");
                    if (!res.ok) return;
                    const data = await res.json();

                    // pastikan angka valid
                    const total = Number(data.total || 0);
                    const comp = Number(data.completed || 0);
                    const ong = Number(data.ongoing || 0);

                    // update stat box
                    const elTotal = document.getElementById('stat-total');
                    const elComp = document.getElementById('stat-completed');
                    const elOng = document.getElementById('stat-ongoing');
                    if (elTotal) elTotal.textContent = total;
                    if (elComp) elComp.textContent = comp;
                    if (elOng) elOng.textContent = ong;

                    // update chart data & labels if previously empty
                    chart.data.datasets[0].data = [comp, ong];

                    // if both zero, show placeholder color/label
                    if ((comp + ong) === 0) {
                        chart.data.labels = ['Belum Ada Data'];
                        chart.data.datasets[0].backgroundColor = ['#e5e7eb'];
                        chart.data.datasets[0].data = [1];
                    } else {
                        chart.data.labels = ['Selesai', 'Sedang Dikerjakan'];
                        chart.data.datasets[0].backgroundColor = ['#22c55e', '#facc15'];
                        chart.data.datasets[0].data = [comp, ong];
                    }

                    chart.update();
                } catch (e) {
                    console.log('Gagal update realtime:', e);
                }
            }

            // jalankan sekali langsung supaya grafik sinkron tanpa nunggu interval
            refreshStats();

            // interval update (3 detik)
            setInterval(refreshStats, 3000);
        });
    </script>

</x-dashboard-layout>
