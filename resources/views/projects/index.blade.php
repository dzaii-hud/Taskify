<x-dashboard-layout title="Proyek Saya">
    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 text-sm border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Proyek Saya</h1>
            <p class="text-sm text-gray-500">
                Kelola daftar proyek yang kamu kerjakan di Taskify.
            </p>
        </div>

        {{-- Tombol Tambah Proyek --}}
        <button onclick="scrollToProjectForm()"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
            + Tambah Proyek
        </button>
    </div>

    {{-- Daftar proyek --}}
    <div class="bg-white rounded-2xl shadow p-4 md:p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Proyek</h2>

        @if ($projects->isEmpty())
            <p class="text-sm text-gray-500">
                Belum ada proyek. Tambahkan proyek pertamamu melalui form di bawah.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left py-2 px-3">Nama Proyek</th>
                            <th class="text-left py-2 px-3">Deadline</th>
                            <th class="text-left py-2 px-3">Status</th>
                            <th class="text-left py-2 px-3">Dibuat</th>
                            <th class="text-left py-2 px-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr class="border-b last:border-0 hover:bg-gray-50">
                                <td class="py-2 px-3 font-medium text-gray-800">
                                    {{ $project->name }}
                                </td>
                                <td class="py-2 px-3 text-gray-600">
                                    {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="py-2 px-3">
                                    @php
                                        $status = $project->status;
                                        $badgeClass = match ($status) {
                                            'To Do' => 'bg-sky-100 text-sky-700',
                                            'Done' => 'bg-emerald-100 text-emerald-700',
                                            default => 'bg-amber-100 text-amber-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="py-2 px-3 text-gray-500">
                                    {{ $project->created_at->diffForHumans() }}
                                </td>

                                {{-- Aksi --}}
                                <td class="py-2 px-3">
                                    <div class="flex items-center gap-2">

                                        {{--
                                          LOGIC:
                                          Jika proyek ini dibuat oleh user yang sedang login → tampilkan semua aksi
                                          Jika bukan pemilik → hanya tampilkan tombol "Lihat Tugas"
                                           --}}
                                        @if ($project->owner_id === auth()->id())
                                            {{-- Edit --}}
                                            <a href="{{ route('projects.edit', $project) }}"
                                                class="inline-flex items-center px-2 py-1 text-xs rounded-md bg-sky-100 text-sky-700 hover:bg-sky-200">
                                                Edit
                                            </a>

                                            {{-- Lihat Tugas --}}
                                            <a href="{{ route('tasks.all') }}?highlight={{ $project->id }}"
                                                class="inline-flex items-center px-2 py-1 text-xs rounded-md bg-indigo-50 text-indigo-700 hover:bg-indigo-100">
                                                Lihat Tugas
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus proyek ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-2 py-1 text-xs rounded-md bg-red-100 text-red-700 hover:bg-red-200">
                                                    Hapus
                                                </button>
                                            </form>
                                        @else
                                            {{-- Bukan pemilik → hanya boleh lihat tugas --}}
                                            <a href="{{ route('tasks.all') }}?highlight={{ $project->id }}"
                                                class="inline-flex items-center px-2 py-1 text-xs rounded-md bg-indigo-50 text-indigo-700 hover:bg-indigo-100">
                                                Lihat Tugas
                                            </a>
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

    {{-- Form Proyek --}}
    <div id="form-proyek" class="bg-white rounded-2xl shadow p-4 md:p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            {{ isset($editing) ? 'Edit Proyek' : 'Tambah Proyek Baru' }}
        </h2>

        <form action="{{ isset($editing) ? route('projects.update', $editing) : route('projects.store') }}"
            method="POST" class="space-y-4">
            @csrf
            @if (isset($editing))
                @method('PUT')
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Proyek <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', isset($editing) ? $editing->name : '') }}"
                    required
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', isset($editing) ? $editing->description : '') }}</textarea>
            </div>

            <div class="max-w-xs">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                <input type="date" name="deadline"
                    value="{{ old('deadline', isset($editing) && $editing->deadline ? \Carbon\Carbon::parse($editing->deadline)->format('Y-m-d') : '') }}"
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                    {{ isset($editing) ? 'Update Proyek' : 'Simpan Proyek' }}
                </button>

                @if (isset($editing))
                    <a href="{{ route('projects.index') }}"
                        class="inline-flex items-center px-3 py-2 rounded-lg border text-sm text-gray-600 hover:bg-gray-50">
                        Batal Edit
                    </a>
                @endif
            </div>
        </form>
    </div>

    <script>
        function scrollToProjectForm() {
            document.getElementById('form-proyek').scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>
</x-dashboard-layout>
