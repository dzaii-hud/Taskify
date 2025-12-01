@php
    use Carbon\Carbon;
@endphp

<x-dashboard-layout title="Semua Tugas">

    <div class="space-y-8">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Semua Tugas Saya</h1>
            <p class="text-sm text-gray-500 mt-1">
                Daftar semua tugas dari semua proyek yang kamu miliki di Taskify.
            </p>
        </div>

        {{-- Flash sukses --}}
        @if (session('success'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Jika tidak ada project dan tidak ada tugas assigned --}}
        @if ($projects->isEmpty() && $tasksAssigned->isEmpty())
            <div class="bg-white rounded-2xl shadow p-6 text-center text-sm text-gray-500">
                Belum ada proyek atau tugas sama sekali.
                <div class="mt-2">Buat proyek dulu di menu <span class="font-semibold">Proyek</span>.</div>
            </div>
        @endif

        {{-- Loop project --}}
        @foreach ($projects as $project)
            @php
                $isProjectOwner = $project->owner_id == auth()->id();
            @endphp

            <div id="project-card-{{ $project->id }}"
                class="bg-white rounded-2xl shadow p-4 md:p-6 transition-all duration-500">

                {{-- Header project --}}
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">{{ $project->name }}</h2>
                        <p class="text-xs text-gray-500">
                            {{ $project->tasks->count() }} tugas

                            @if (!$isProjectOwner)
                                <span class="block text-xs text-gray-500 italic mt-1">(Project Di-Assign Admin)</span>
                            @endif
                        </p>
                    </div>

                    {{-- Kelola --}}
                    @if ($isProjectOwner)
                        <a href="{{ route('projects.tasks.index', $project) }}"
                            class="px-3 py-1 text-xs rounded-md bg-indigo-50 text-indigo-700 hover:bg-indigo-100">
                            Kelola Tugas
                        </a>
                    @else
                        <a href="{{ route('projects.tasks.index', $project) }}"
                            class="px-3 py-1 text-xs rounded-md bg-indigo-50 text-indigo-700 opacity-60 pointer-events-none cursor-not-allowed">
                            Kelola Tugas
                        </a>
                    @endif
                </div>

                @if ($project->tasks->isEmpty())
                    <p class="text-sm text-gray-500 italic">Belum ada tugas di proyek ini.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="text-sm table-auto w-full">
                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="text-left py-2 px-3">Tugas</th>
                                    <th class="text-left py-2 px-3">Status</th>
                                    <th class="text-left py-2 px-3">Deadline</th>
                                    <th class="text-left py-2 px-3">Prioritas</th>
                                    <th class="text-left py-2 px-3">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($project->tasks as $task)
                                    @php
                                        $statusLabel =
                                            [
                                                'on_going' => 'On Going',
                                                'done' => 'Done',
                                            ][$task->status] ?? 'On Going';

                                        $statusClass =
                                            [
                                                'on_going' => 'bg-amber-100 text-amber-800',
                                                'done' => 'bg-emerald-100 text-emerald-800',
                                            ][$task->status] ?? 'bg-amber-100 text-amber-800';

                                        $priorityLabel = [
                                            1 => 'Rendah',
                                            2 => 'Menengah',
                                            3 => 'Tinggi',
                                        ][$task->priority];

                                        $isAssignedToMe = $task->assigned_to == auth()->id();
                                        $isAssigner = $task->assigned_by == auth()->id();

                                        /* FIX — tugas boleh diceklis jika:
                                            1. ditugaskan ke user
                                            2. user adalah pemilik proyek (tugas sendiri otomatis bisa)
                                        */
                                        $canChecklist = $isAssignedToMe || $isProjectOwner;

                                        /* edit & hapus */
                                        $canEditDelete = $isAssigner || $isProjectOwner;
                                    @endphp

                                    <tr class="border-b last:border-0 hover:bg-gray-50">

                                        {{-- Tugas --}}
                                        <td class="py-2 px-3 align-top">
                                            <div class="font-medium text-gray-800">{{ $task->title }}</div>
                                            @if ($task->description)
                                                <div class="text-xs text-gray-500 mt-1 max-w-md">
                                                    {{ $task->description }}
                                                </div>
                                            @endif

                                            @if (!$isAssignedToMe && !$isProjectOwner)
                                                <div class="text-xs text-gray-500 italic mt-1">
                                                    (Tugas Tidak Ditugaskan Kepada Anda)
                                                </div>
                                            @endif
                                        </td>

                                        {{-- Status --}}
                                        <td class="py-2 px-3 whitespace-nowrap">
                                            <span
                                                class="px-2.5 py-0.5 text-xs rounded-full font-medium {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        {{-- Deadline --}}
                                        <td class="py-2 px-3 whitespace-nowrap text-gray-600">
                                            @if ($task->deadline)
                                                {{ Carbon::parse($task->deadline)->translatedFormat('d M Y') }}
                                            @else
                                                <span class="text-xs italic text-gray-400">Belum diatur</span>
                                            @endif
                                        </td>

                                        {{-- Priority --}}
                                        <td class="py-2 px-3 whitespace-nowrap text-gray-600">
                                            {{ $priorityLabel }}
                                        </td>

                                        {{-- Aksi --}}
                                        <td class="py-2 px-3 whitespace-nowrap">
                                            <div class="flex items-center gap-2">


                                                {{-- EDIT / HAPUS --}}
                                                @if ($canEditDelete)
                                                    <a href="{{ route('projects.tasks.edit', [$project, $task]) }}"
                                                        class="px-2 py-1 text-xs bg-sky-100 text-sky-700 rounded-md hover:bg-sky-200">
                                                        Edit
                                                    </a>

                                                    <form
                                                        action="{{ route('projects.tasks.destroy', [$project, $task]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus tugas ini?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-md hover:bg-red-200">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- CEKLIS --}}
                                                @if ($canChecklist)
                                                    @if ($task->status !== 'done')
                                                        <form action="{{ route('tasks.complete', $task) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button
                                                                class="px-2 py-1 text-xs bg-green-500 text-white rounded-md hover:bg-green-600">
                                                                ✓ Selesai
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-xs text-emerald-600 font-medium">
                                                            ✔ Sudah Selesai
                                                        </span>
                                                    @endif
                                                @else
                                                    <div class="text-xs text-gray-400 italic">
                                                        (Tidak Bisa Checklist)
                                                    </div>
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
        @endforeach

    </div>

</x-dashboard-layout>

{{-- Highlight --}}
@if ($highlight)
    <script>
        setTimeout(() => {
            const el = document.getElementById('project-card-{{ $highlight }}');
            if (el) {
                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                el.classList.add('ring-2', 'ring-indigo-400');
                setTimeout(() => el.classList.remove('ring-2', 'ring-indigo-400'), 2000);
            }
        }, 300);
    </script>
@endif
