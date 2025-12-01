<x-admin-layout title="Buat Tugas Baru">

    <div class="p-6">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-purple-300">Buat Tugas Baru</h1>
            <p class="text-gray-400 text-sm">Buat tugas dan (opsional) assign ke user.</p>
        </div>

        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20">
            <form action="{{ route('admin.tasks.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-4">

                    {{-- Nama Tugas --}}
                    <div>
                        <label class="text-sm text-gray-300">Nama Tugas <span class="text-red-400">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                            class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200"
                            required>
                        @error('title')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Proyek --}}
                    <div>
                        <label class="text-sm text-gray-300">Pilih Proyek <span class="text-red-400">*</span></label>
                        <select name="project_id"
                            class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200"
                            required>

                            <option value="">-- Pilih Proyek --</option>

                            @foreach ($projects as $p)
                                <option value="{{ $p->id }}" @if (old('project_id') == $p->id) selected @endif>
                                    {{ $p->name }}
                                </option>
                            @endforeach

                        </select>
                        @error('project_id')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Assign ke User (Opsional) --}}
                    <div>
                        <label class="text-sm text-gray-300">Assign ke User (Opsional)</label>
                        <select name="assigned_to"
                            class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200">

                            <option value="">-- Tidak diassign --</option>

                            @foreach ($users as $u)
                                <option value="{{ $u->id }}" @if (old('assigned_to') == $u->id) selected @endif>
                                    {{ $u->name }} ({{ $u->email }})
                                </option>
                            @endforeach

                        </select>
                        @error('assigned_to')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="text-sm text-gray-300">Deskripsi</label>
                        <textarea name="description" rows="4"
                            class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deadline --}}
                    <div>
                        <label class="text-sm text-gray-300">Deadline</label>
                        <input type="date" name="deadline" value="{{ old('deadline') }}"
                            class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200">
                        @error('deadline')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Priority --}}
                    <div>
                        <label class="text-sm text-gray-300">Prioritas <span class="text-red-400">*</span></label>
                        <select name="priority"
                            class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200"
                            required>

                            <option value="">-- Pilih Prioritas --</option>
                            <option value="1" @selected(old('priority') == 1)>Low</option>
                            <option value="2" @selected(old('priority') == 2)>Medium</option>
                            <option value="3" @selected(old('priority') == 3)>High</option>

                        </select>
                        @error('priority')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="pt-4">
                        <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded">
                            Simpan Tugas
                        </button>

                        <a href="{{ route('admin.tasks.index') }}" class="ml-3 text-sm text-gray-300">Batal</a>
                    </div>

                </div>
            </form>
        </div>

    </div>

</x-admin-layout>
