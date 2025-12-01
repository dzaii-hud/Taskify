<x-admin-layout title="Edit Tugas">

    <div class="p-6 space-y-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-purple-300">Edit Tugas</h1>

            <a href="{{ route('admin.tasks.index') }}"
                class="px-4 py-2 bg-gray-700 hover:bg-gray-600 transition text-white rounded-lg shadow">
                ← Kembali
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="bg-[#1b1b2f] border border-purple-700/20 rounded-xl p-6 shadow space-y-6">

            <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- TITLE --}}
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Judul Tugas</label>
                    <input type="text" name="title" value="{{ old('title', $task->title) }}"
                        class="w-full p-2 rounded bg-[#252542] text-gray-200 border border-purple-700/30">
                </div>

                {{-- PROJECT --}}
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Proyek</label>
                    <select name="project_id"
                        class="w-full p-2 rounded bg-[#252542] text-gray-200 border border-purple-700/30">
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"
                                {{ $task->project_id == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ASSIGNED TO --}}
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Assign Ke</label>
                    <select name="assigned_to"
                        class="w-full p-2 rounded bg-[#252542] text-gray-200 border border-purple-700/30">
                        <option value="">— Tidak Ada —</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full p-2 rounded bg-[#252542] text-gray-200 border border-purple-700/30">{{ old('description', $task->description) }}</textarea>
                </div>

                {{-- DEADLINE --}}
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Deadline</label>
                    <input type="date" name="deadline"
                        value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}"
                        class="w-full p-2 rounded bg-[#252542] text-gray-200 border border-purple-700/30">
                </div>

                {{-- PRIORITY --}}
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Prioritas</label>
                    <select name="priority"
                        class="w-full p-2 rounded bg-[#252542] text-gray-200 border border-purple-700/30">
                        <option value="1" {{ $task->priority == 1 ? 'selected' : '' }}>Low</option>
                        <option value="2" {{ $task->priority == 2 ? 'selected' : '' }}>Medium</option>
                        <option value="3" {{ $task->priority == 3 ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                {{-- BUTTONS --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.tasks.index') }}"
                        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg">
                        Batal
                    </a>

                    <button class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-admin-layout>
