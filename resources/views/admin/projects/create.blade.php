<x-admin-layout title="Buat Proyek Baru">

    <div class="p-6">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-purple-300">Buat Proyek Baru</h1>
            <p class="text-gray-400 text-sm">Buat proyek dan (opsional) assign ke user.</p>
        </div>

        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20">
            <form action="{{ route('admin.projects.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="text-sm text-gray-300">Nama Proyek <span class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200"
                            required>
                        @error('name')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-300">Deskripsi</label>
                        <textarea name="description" class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200"
                            rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-300">Deadline</label>
                            <input type="date" name="deadline" value="{{ old('deadline') }}"
                                class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200">
                            @error('deadline')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm text-gray-300">Assign ke (opsional)</label>
                            <select name="assigned_to"
                                class="w-full mt-1 p-2 rounded bg-[#252542] border border-purple-700/20 text-gray-200">
                                <option value="">-- Tidak diassign --</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}"
                                        @if (old('assigned_to') == $u->id) selected @endif>
                                        {{ $u->name }} ({{ $u->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded">
                            Simpan Proyek
                        </button>

                        <a href="{{ route('admin.projects.index') }}" class="ml-3 text-sm text-gray-300">Batal</a>
                    </div>
                </div>
            </form>
        </div>

    </div>

</x-admin-layout>
