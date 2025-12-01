<x-admin-layout title="Daftar Tugas">

    <div class="p-6 space-y-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-purple-300">Daftar Tugas</h1>

            <a href="{{ route('admin.tasks.create') }}"
                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 transition text-white rounded-lg shadow">
                + Tambah Tugas
            </a>
        </div>

        {{-- TABLE LIST --}}
        <div class="bg-[#1b1b2f] shadow border border-purple-700/20 rounded-xl overflow-hidden">

            <table class="w-full text-sm text-gray-300">
                <thead class="bg-[#252542]">
                    <tr>
                        <th class="p-3 text-left">Nama Tugas</th>
                        <th class="p-3 text-left">Proyek</th>
                        <th class="p-3 text-left">Assigned To</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Deadline</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($tasks as $task)
                        <tr class="border-b border-purple-700/10 hover:bg-purple-600/10 transition">

                            {{-- Nama Tugas --}}
                            <td class="p-3 font-medium">
                                {{ $task->display_name ?? ($task->title ?? ($task->name ?? '-')) }}
                            </td>

                            {{-- Proyek --}}
                            <td class="p-3">
                                {{ optional($task->project)->display_name ?? (optional($task->project)->name ?? '-') }}
                            </td>

                            {{-- Assigned To --}}
                            <td class="p-3">
                                {{ optional($task->assignedTo)->name ?? '-' }}
                            </td>

                            {{-- STATUS --}}
                            <td class="p-3">
                                @php
                                    $statusNorm = strtolower($task->normalized_status ?? ($task->status ?? 'on_going'));
                                    $label = $task->status_label ?? ucfirst($task->status ?? 'On Going');
                                @endphp

                                <span
                                    class="px-2 py-1 rounded text-xs
                                    {{ $statusNorm === 'done' ? 'bg-green-600/30 text-green-300' : 'bg-yellow-600/30 text-yellow-300' }}">
                                    {{ $label }}
                                </span>
                            </td>

                            {{-- DEADLINE SAFE --}}
                            <td class="p-3">
                                @if (!empty($task->deadline))
                                    @php
                                        try {
                                            $d = \Illuminate\Support\Carbon::parse($task->deadline);
                                        } catch (\Exception $e) {
                                            $d = null;
                                        }
                                    @endphp
                                    {{ $d ? $d->format('Y-m-d') : $task->deadline }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- ACTIONS (4 BUTTONS) --}}
                            <td class="p-3 flex gap-2">

                                {{-- Assign --}}
                                <a href="{{ route('admin.assign.task', $task->id) }}"
                                    class="px-3 py-1 text-xs rounded bg-purple-600/40 text-purple-200 hover:bg-purple-600/60">
                                    Assign
                                </a>

                                {{-- Detail --}}
                                <a href="{{ route('admin.tasks.show', $task->id) }}"
                                    class="px-3 py-1 text-xs rounded bg-blue-800/40 text-blue-300 hover:bg-blue-800/60">
                                    Detail
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                    class="px-3 py-1 text-xs rounded bg-blue-600/40 text-blue-200 hover:bg-blue-600/60">
                                    Edit
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-1 text-xs rounded bg-red-600/40 text-red-300 hover:bg-red-600/60">
                                        Hapus
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 p-6">
                                Tidak ada tugas tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</x-admin-layout>
