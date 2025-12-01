<x-admin-layout title="Detail Tugas">

    <div class="p-6 space-y-8">

        <h1 class="text-2xl font-bold text-purple-300 mb-4">Detail Tugas</h1>

        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20 space-y-4">

            {{-- Nama Tugas --}}
            <div>
                <h2 class="text-sm text-gray-400">Nama Tugas</h2>
                <p class="text-lg font-semibold">{{ $task->display_name ?? ($task->title ?? '-') }}</p>
            </div>

            {{-- Proyek --}}
            <div>
                <h2 class="text-sm text-gray-400">Proyek</h2>
                <p>{{ optional($task->project)->display_name ?? '-' }}</p>
            </div>

            {{-- Assigned To --}}
            <div>
                <h2 class="text-sm text-gray-400">Assigned To</h2>
                <p>{{ optional($task->assignedTo)->name ?? '-' }}</p>
            </div>

            {{-- Status --}}
            <div>
                <h2 class="text-sm text-gray-400">Status</h2>
                @php
                    $statusNorm = strtolower($task->normalized_status ?? ($task->status ?? 'on_going'));
                    $label = $task->status_label ?? ucfirst($task->status ?? 'On Going');
                @endphp

                <span
                    class="px-3 py-1 rounded text-xs
                    {{ $statusNorm === 'done' ? 'bg-green-600/30 text-green-300' : 'bg-yellow-600/30 text-yellow-300' }}">
                    {{ $label }}
                </span>
            </div>

            {{-- Deadline --}}
            <div>
                <h2 class="text-sm text-gray-400">Deadline</h2>
                <p>{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : '-' }}</p>
            </div>
        </div>

        {{-- BUTTON BACK --}}
        <a href="{{ route('admin.tasks.index') }}"
            class="px-4 py-2 bg-purple-700 hover:bg-purple-800 text-white rounded-lg transition">
            ← Kembali
        </a>

    </div>

</x-admin-layout>
