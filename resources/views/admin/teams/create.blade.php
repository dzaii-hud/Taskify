<x-admin-layout title="Buat Tim Baru">

    <div class="p-6">

        <h1 class="text-2xl font-semibold text-purple-300 mb-4">Buat Tim Baru</h1>

        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20">
            <form action="{{ route('admin.teams.store') }}" method="POST">
                @csrf

                <div>
                    <label class="text-gray-300 text-sm">Nama Tim</label>
                    <input type="text" name="team_name" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200"
                        required>
                </div>

                <div class="mt-4">
                    <label class="text-gray-300 text-sm">Pilih Leader (opsional)</label>
                    <select name="leader_id" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                        <option value="">-- Tidak ada --</option>
                        @foreach (\App\Models\User::orderBy('name')->get() as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label class="text-gray-300 text-sm">Tambah Anggota (opsional)</label>
                    <select name="members[]" multiple class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                        @foreach (\App\Models\User::orderBy('name')->get() as $u)
                            <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <button class="px-4 py-2 bg-purple-600 rounded text-white">Buat Tim</button>
                    <a href="{{ route('admin.users.index') }}" class="ml-3 text-gray-300">Batal</a>
                </div>

            </form>
        </div>

    </div>

</x-admin-layout>
