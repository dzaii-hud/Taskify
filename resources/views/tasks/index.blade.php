@php
    use Carbon\Carbon;
@endphp

<x-dashboard-layout :title="'Tugas - ' . $project->name">
    <div class="space-y-8">

        {{-- Flash sukses --}}
        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error validasi --}}
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-200">
                <div class="font-semibold mb-1">Terjadi kesalahan:</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- HEADER PROYEK + PROGRESS --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-400">Proyek</p>
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $project->name }}
                </h1>
                @if ($project->description)
                    <p class="mt-1 text-sm text-gray-500 max-w-xl">
                        {{ $project->description }}
                    </p>
                @endif
            </div>

            @php
                $totalTasks = $tasks->count();
                $doneTasks = $tasks->where('status', 'done')->count();
                $percent = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;

                // perbaikan kecil
                $isProjectOwner = $project->owner_id === auth()->id();
            @endphp

            <div class="flex flex-col items-start md:items-end gap-2">
                <a href="{{ route('projects.index') }}" class="text-xs text-gray-500 hover:text-gray-700">
                    ← Kembali ke daftar proyek
                </a>

                <div>
                    <p class="text-xs text-gray-500 mb-1">Progress tugas</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $percent }}%
                        <span class="text-xs font-normal text-gray-500">
                            ({{ $doneTasks }}/{{ $totalTasks }})
                        </span>
                    </p>
                    <div class="mt-1 h-2 w-48 rounded-full bg-gray-100 overflow-hidden">
                        <div class="h-2 bg-indigo-500 rounded-full" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- DAFTAR TUGAS --}}
        <div class="bg-white rounded-2xl shadow p-4 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Tugas dalam proyek ini</h2>

                {{-- Tombol tambah hanya untuk owner --}}
                @if ($isProjectOwner)
                    <a href="#form-tugas"
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-medium hover:bg-indigo-100">
                        + Tambah Tugas
                    </a>
                @else
                    <a href="#form-tugas"
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-medium opacity-60 pointer-events-none cursor-not-allowed"
                        aria-disabled="true" title="Anda tidak dapat menambah tugas pada proyek ini">
                        + Tambah Tugas
                    </a>
                @endif
            </div>

            @if ($tasks->isEmpty())
                <p class="text-sm text-gray-500">
                    Belum ada tugas. Tambahkan tugas pertama melalui form di bawah.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left py-2 px-3">Judul</th>
                                <th class="text-left py-2 px-3">Status</th>
                                <th class="text-left py-2 px-3">Deadline</th>
                                <th class="text-left py-2 px-3">Prioritas</th>
                                <th class="text-left py-2 px-3">Dibuat</th>
                                <th class="text-left py-2 px-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                @php
                                    $status = $task->status;
                                    $statusLabel =
                                        [
                                            'on_going' => 'On Going',
                                            'done' => 'Done',
                                        ][$status] ?? 'On Going';

                                    $statusClass =
                                        [
                                            'on_going' => 'bg-amber-100 text-amber-800',
                                            'done' => 'bg-emerald-100 text-emerald-800',
                                        ][$status] ?? 'bg-amber-100 text-amber-800';

                                    $priority = (int) $task->priority;
                                    $priorityLabel = match ($priority) {
                                        1 => 'Rendah',
                                        3 => 'Tinggi',
                                        default => 'Menengah',
                                    };

                                    $isAssignedToMe = $task->assigned_to === auth()->id();
                                    $isAssigner = $task->assigned_by === auth()->id();
                                @endphp

                                <tr class="border-b last:border-0 hover:bg-gray-50">
                                    <td class="py-2 px-3 align-top">
                                        <div class="font-medium text-gray-800">
                                            {{ $task->title }}
                                        </div>
                                        @if ($task->description)
                                            <div class="mt-1 text-xs text-gray-500 max-w-md">
                                                {{ $task->description }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="py-2 px-3 align-top whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    <td class="py-2 px-3 align-top whitespace-nowrap text-gray-600">
                                        @if ($task->deadline)
                                            {{ Carbon::parse($task->deadline)->translatedFormat('d M Y') }}
                                        @else
                                            <span class="text-xs text-gray-400 italic">Belum diatur</span>
                                        @endif
                                    </td>

                                    <td class="py-2 px-3 align-top whitespace-nowrap text-gray-600">
                                        {{ $priorityLabel }}
                                    </td>

                                    <td class="py-2 px-3 align-top whitespace-nowrap text-gray-500">
                                        {{ $task->created_at?->diffForHumans() }}
                                    </td>

                                    <td class="py-2 px-3 align-top whitespace-nowrap">
                                        <div class="flex items-center gap-2">

                                            {{-- Tugas assigned ke saya --}}
                                            @if ($isAssignedToMe)
                                                @if ($task->status !== 'done')
                                                    <form action="{{ route('tasks.complete', $task) }}" method="POST">
                                                        @csrf
                                                        <button
                                                            class="inline-flex items-center px-2 py-1 text-xs rounded-md bg-green-500 text-white hover:bg-green-600">
                                                            ✓ Selesai
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-emerald-600 font-medium">✔</span>
                                                @endif
                                            @else
                                                <div class="text-xs text-gray-500 italic">(Tugas Tidak Ditugaskan Kepada
                                                    Anda)</div>
                                            @endif

                                            {{-- EDIT & DELETE — Owner proyek selalu boleh --}}
                                            @if ($isProjectOwner)
                                                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}"
                                                    class="inline-flex items-center px-2 py-1 text-xs rounded-md bg-sky-100 text-sky-700 hover:bg-sky-200">
                                                    Edit
                                                </a>

                                                <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus tugas ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-2 py-1 text-xs rounded-md bg-red-100 text-red-700 hover:bg-red-200">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- FORM TAMBAH / EDIT --}}
        <div id="form-tugas" class="bg-white rounded-2xl shadow p-4 md:p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">
                {{ isset($editing) ? 'Edit Tugas' : 'Tambah Tugas Baru' }}
            </h2>
            <p class="text-xs text-gray-500 mb-4">
                {{ isset($editing)
                    ? 'Perbarui detail tugas untuk proyek ini.'
                    : 'Buat tugas baru untuk mengorganisir pekerjaan di proyek ini.' }}
            </p>

            @if (!$isProjectOwner)
                <div class="mb-4 p-3 rounded-lg bg-yellow-50 text-yellow-700 text-sm border border-yellow-200">
                    Anda tidak memiliki izin untuk menambah atau mengedit tugas pada proyek ini.
                </div>
            @else
                @if (isset($editing))
                    <div class="mb-4">
                        <a href="{{ route('projects.tasks.index', $project) }}"
                            class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-700">
                            Batal edit & kembali ke mode tambah
                        </a>
                    </div>
                @endif

                <form
                    action="{{ isset($editing)
                        ? route('projects.tasks.update', [$project, $editing])
                        : route('projects.tasks.store', $project) }}"
                    method="POST" class="space-y-4">
                    @csrf
                    @if (isset($editing))
                        @method('PUT')
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Judul Tugas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $editing->title ?? '') }}" required
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3"
                            class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Tuliskan detail singkat tentang tugas ini...">{{ old('description', $editing->description ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                            <input type="date" name="deadline" value="{{ old('deadline', $deadlineValue ?? '') }}"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                            @php
                                $currentPriority = (int) old('priority', $editing->priority ?? 2);
                            @endphp
                            <select name="priority"
                                class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500">
                                <option value="1" {{ $currentPriority === 1 ? 'selected' : '' }}>Rendah</option>
                                <option value="2" {{ $currentPriority === 2 ? 'selected' : '' }}>Menengah</option>
                                <option value="3" {{ $currentPriority === 3 ? 'selected' : '' }}>Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                            {{ isset($editing) ? 'Simpan Perubahan Tugas' : 'Simpan Tugas' }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-dashboard-layout>
