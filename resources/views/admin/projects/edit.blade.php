<x-admin-layout title="Edit Proyek">

    <div class="p-6 space-y-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-purple-300">Edit Proyek</h1>

            <a href="{{ route('admin.projects.index') }}"
                class="px-4 py-2 bg-gray-700 hover:bg-gray-600 transition text-white rounded-lg shadow">
                ← Kembali
            </a>
        </div>

        {{-- FORM CARD --}}
        <div class="bg-[#1b1b2f] border border-purple-700/20 rounded-xl p-6 shadow space-y-6">

            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- NAMA PROYEK --}}
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Nama Proyek</label>
                    <input type="text" name="name" value="{{ old('name', $project->name) }}"
                        class="w-full p-2 rounded bg-[#252542] text-gray-200 border border-purple-700/30">
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <label class="block text-gray-300 font-medium mb-1">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full p-2 rounded bg-[#252542] text-gray-200 border border-purple-700/30">{{ old('description', $project->description) }}</textarea>
                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.projects.index') }}"
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
