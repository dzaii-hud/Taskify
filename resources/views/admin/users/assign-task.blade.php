<x-admin-layout title="Assign Tugas ke User">

    <div class="p-6">

        <h1 class="text-2xl font-semibold text-purple-300 mb-4">Assign Tugas</h1>

        <div class="bg-[#1b1b2f] p-6 rounded-xl border border-purple-700/20">
            <form action="{{ route('admin.assign.task') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-gray-300 text-sm">Pilih User</label>
                        <select name="user_id" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                            <option value="">-- Pilih User --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-gray-300 text-sm">Pilih Proyek</label>
                        <select name="project_id" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                            <option value="">-- Pilih Proyek --</option>
                            @foreach ($projects as $p)
                                <option value="{{ $p->id }}">{{ $p->display_name }} (Owner:
                                    {{ optional($p->owner)->name ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-gray-300 text-sm">Judul Tugas</label>
                        <input type="text" name="title" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200"
                            required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-gray-300 text-sm">Deskripsi (opsional)</label>
                        <textarea name="description" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200"></textarea>
                    </div>

                    <div>
                        <label class="text-gray-300 text-sm">Priority</label>
                        <select name="priority" class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                            <option value="2">Menengah</option>
                            <option value="3">Tinggi</option>
                            <option value="1">Rendah</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-gray-300 text-sm">Deadline (opsional)</label>
                        <input type="date" name="deadline"
                            class="w-full mt-2 p-2 rounded bg-[#252542] text-gray-200">
                    </div>
                </div>

                <div class="mt-4">
                    <button class="px-4 py-2 bg-yellow-600 rounded text-white">Buat & Assign</button>
                    <a href="{{ route('admin.users.index') }}" class="ml-3 text-gray-300">Batal</a>
                </div>

            </form>
        </div>

    </div>

</x-admin-layout>
