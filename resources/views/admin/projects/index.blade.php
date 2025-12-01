<x-admin-layout title="Manajemen Proyek">

    <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20">

        {{-- HEADER + BUTTON TAMBAH PROYEK --}}
        <div class="flex justify-between items-center mb-5">
            <h1 class="text-xl font-semibold text-purple-300">Manajemen Proyek</h1>

            <a href="{{ route('admin.projects.create') }}"
                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium transition">
                + Tambah Proyek
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-purple-700/20">
            <table class="w-full text-left text-gray-300 text-sm">

                <thead class="bg-[#252542]">
                    <tr>
                        <th class="p-3">Nama Proyek</th>
                        <th class="p-3">Progress</th>
                        <th class="p-3">Total Tugas</th>
                        <th class="p-3">Tugas Selesai</th>
                        <th class="p-3">Dibuat</th>

                        {{-- FIXED WIDTH untuk menyelaraskan teks Aksi dengan tombol --}}
                        <th class="p-3 w-48">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($projects as $project)
                        <tr class="border-b border-purple-700/10">

                            {{-- NAMA PROYEK --}}
                            <td class="p-3 font-medium">
                                {{ $project->display_name }}
                            </td>

                            {{-- PROGRESS --}}
                            <td class="p-3">
                                {{ $project->progress }}%
                            </td>

                            {{-- TOTAL TUGAS --}}
                            <td class="p-3">
                                {{ $project->tasks_count }}
                            </td>

                            {{-- TUGAS SELESAI --}}
                            <td class="p-3">
                                {{ $project->done_tasks }}
                            </td>

                            {{-- DIBUAT --}}
                            <td class="p-3">
                                {{ $project->created_at->format('Y-m-d') }}
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4 flex gap-2">

                                {{-- Assign --}}
                                <a href="{{ route('admin.assign.project', $project->id) }}"
                                    class="px-3 py-1 text-xs rounded bg-purple-600/40 text-purple-200 hover:bg-purple-600/60">
                                    Assign
                                </a>

                                {{-- Detail --}}
                                <a href="{{ route('admin.projects.show', $project->id) }}"
                                    class="px-3 py-1 text-xs rounded bg-blue-800/40 text-blue-300 hover:bg-blue-800/60">
                                    Detail
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.projects.edit', $project->id) }}"
                                    class="px-3 py-1 text-xs rounded bg-blue-600/40 text-blue-200 hover:bg-blue-600/60">
                                    Edit
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus proyek ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="px-3 py-1 text-xs rounded bg-red-600/40 text-red-300 hover:bg-red-600/60">
                                        Hapus
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $projects->links() }}
        </div>

    </div>

</x-admin-layout>
